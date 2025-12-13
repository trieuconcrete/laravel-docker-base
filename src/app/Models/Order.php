<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'type',
        'item_name',
        'item_description',
        'quantity',
        'unit_price',
        'total_amount',
        'payment_method',
        'status',
        'paid_at',
        'completed_at',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    const TYPE_SUBSCRIPTION = 'subscription';
    const TYPE_VIDEO_REVIEW = 'video_review';
    const TYPE_COUNSELING = 'counseling';
    const TYPE_VIDEO_EDIT_SINGLE = 'video_edit_single';
    const TYPE_VIDEO_EDIT_5PACK = 'video_edit_5pack';
    const TYPE_VIDEO_EDIT_10PACK = 'video_edit_10pack';
    const TYPE_PRIORITY_REPLY = 'priority_reply';
    const TYPE_OTHER = 'other';

    const TYPE_LABELS = [
        'subscription' => 'サブスクリプション',
        'video_review' => '動画添削',
        'counseling' => '個別カウンセリング',
        'video_edit_single' => '単品動画編集',
        'video_edit_5pack' => '動画編集5本セット',
        'video_edit_10pack' => '動画編集10本セット',
        'priority_reply' => '優先返信オプション',
        'other' => 'その他',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_REFUNDED = 'refunded';

    const STATUS_LABELS = [
        'pending' => '受付済',
        'confirmed' => '決済確認済',
        'processing' => '処理中',
        'completed' => '完了',
        'cancelled' => 'キャンセル',
        'refunded' => '返金済',
    ];

    /**
     * Get the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get payments for this order
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get type label
     */
    public function getTypeLabelAttribute(): string
    {
        return self::TYPE_LABELS[$this->type] ?? 'その他';
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? '不明';
    }

    /**
     * Get formatted total amount
     */
    public function getFormattedTotalAttribute(): string
    {
        return '¥' . number_format($this->total_amount);
    }

    /**
     * Generate order number
     */
    public static function generateOrderNumber(): string
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -5));
        
        return "{$prefix}-{$date}-{$random}";
    }

    /**
     * Boot method - auto-generate order_number
     */
    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            if (empty($order->order_number)) {
                $order->order_number = self::generateOrderNumber();
            }
        });
    }
}

