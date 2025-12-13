<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'started_at',
        'expires_at',
        'cancelled_at',
        'cancel_reason',
        'priority_reply',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'date',
            'expires_at' => 'date',
            'cancelled_at' => 'date',
            'priority_reply' => 'boolean',
        ];
    }

    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_ACTIVE = 'active';
    const STATUS_CANCELLING = 'cancelling';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_EXPIRED = 'expired';

    const STATUS_LABELS = [
        'pending' => '受付済',
        'confirmed' => '決済確認済',
        'active' => '提供中',
        'cancelling' => '解約申請中',
        'cancelled' => '解約済',
        'expired' => '期限切れ',
    ];

    /**
     * Get the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the plan
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? '不明';
    }

    /**
     * Check if subscription is active
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Scope for active subscriptions
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }
}

