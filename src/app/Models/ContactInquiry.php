<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'topics',
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'assigned_to',
        'admin_notes',
        'replied_at',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'topics' => 'array',
            'replied_at' => 'datetime',
            'resolved_at' => 'datetime',
        ];
    }

    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_WAITING = 'waiting';
    const STATUS_RESOLVED = 'resolved';
    const STATUS_CLOSED = 'closed';

    const STATUS_LABELS = [
        'new' => '新規',
        'in_progress' => '対応中',
        'waiting' => '返信待ち',
        'resolved' => '解決済み',
        'closed' => 'クローズ',
    ];

    const TOPIC_OPTIONS = [
        'sns' => 'SNS運用サポートについて',
        'review' => '動画添削について',
        'edit' => '動画編集について',
        'counseling' => '個別カウンセリングについて',
        'subscription' => 'サブスクリプションについて',
        'payment' => 'お支払いについて',
        'other' => 'その他',
    ];

    /**
     * Get the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get assigned admin
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? '不明';
    }

    /**
     * Get topics as labels
     */
    public function getTopicLabelsAttribute(): array
    {
        if (!$this->topics) {
            return [];
        }

        return array_map(function ($topic) {
            return self::TOPIC_OPTIONS[$topic] ?? $topic;
        }, $this->topics);
    }

    /**
     * Scope for new inquiries
     */
    public function scopeNew($query)
    {
        return $query->where('status', self::STATUS_NEW);
    }

    /**
     * Scope for unresolved inquiries
     */
    public function scopeUnresolved($query)
    {
        return $query->whereNotIn('status', [self::STATUS_RESOLVED, self::STATUS_CLOSED]);
    }
}

