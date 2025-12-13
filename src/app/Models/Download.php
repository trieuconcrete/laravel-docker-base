<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'category',
        'user_id',
        'plan_required',
        'is_public',
        'is_active',
        'download_count',
    ];

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    const CATEGORY_GUIDE = 'guide';
    const CATEGORY_REPORT = 'report';
    const CATEGORY_BONUS = 'bonus';
    const CATEGORY_DELIVERABLE = 'deliverable';
    const CATEGORY_OTHER = 'other';

    const CATEGORY_LABELS = [
        'guide' => '利用ガイド',
        'report' => '運営レポート',
        'bonus' => '特典資料',
        'deliverable' => '成果物',
        'other' => 'その他',
    ];

    /**
     * Get the user (for user-specific downloads)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get category label
     */
    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORY_LABELS[$this->category] ?? 'その他';
    }

    /**
     * Get formatted file size
     */
    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->file_size;
        
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        
        return $bytes . ' B';
    }

    /**
     * Scope for active downloads
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for public downloads
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Check if user can access this download
     */
    public function canAccess(User $user): bool
    {
        // Public downloads are accessible to everyone
        if ($this->is_public) {
            return true;
        }

        // User-specific downloads
        if ($this->user_id && $this->user_id === $user->id) {
            return true;
        }

        // Plan-based access
        if ($this->plan_required) {
            $subscription = $user->activeSubscription;
            if ($subscription && $subscription->plan->slug === $this->plan_required) {
                return true;
            }
            // Premium can access basic content too
            if ($this->plan_required === 'basic' && $subscription && $subscription->plan->slug === 'premium') {
                return true;
            }
        }

        return false;
    }

    /**
     * Increment download count
     */
    public function incrementDownloads(): void
    {
        $this->increment('download_count');
    }

    /**
     * Check if the file exists on disk
     */
    public function fileExists(): bool
    {
        if (!$this->file_path) {
            return false;
        }
        
        return \Illuminate\Support\Facades\Storage::disk('local')->exists($this->file_path);
    }

    /**
     * Get the full file path
     */
    public function getFullPathAttribute(): string
    {
        return \Illuminate\Support\Facades\Storage::disk('local')->path($this->file_path);
    }
}

