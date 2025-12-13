<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // User Roles
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role',
        'name',
        'email',
        'phone',
        'postal_code',
        'address',
        'password',
    ];

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user is regular user
     */
    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    /**
     * Get role label
     */
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            self::ROLE_ADMIN => '管理者',
            self::ROLE_USER => '一般ユーザー',
            default => '不明'
        };
    }

    /**
     * Get user's active subscription
     */
    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)->where('status', 'active');
    }

    /**
     * Get all subscriptions
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get user's orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get user's payments
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get user's downloads
     */
    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    /**
     * Get user's contact inquiries
     */
    public function contactInquiries()
    {
        return $this->hasMany(ContactInquiry::class);
    }

    /**
     * Check if user has active subscription
     */
    public function hasActiveSubscription(): bool
    {
        return $this->activeSubscription()->exists();
    }

    /**
     * Get subscription status label
     */
    public function getSubscriptionStatusLabel(): string
    {
        $subscription = $this->activeSubscription;
        
        if (!$subscription) {
            return '未登録';
        }

        return match($subscription->status) {
            'pending' => '受付済',
            'confirmed' => '決済確認済',
            'active' => '提供中',
            'cancelling' => '解約申請中',
            'cancelled' => '解約済',
            'expired' => '期限切れ',
            default => '不明'
        };
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
