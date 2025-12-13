<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Download;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ========================================
        // 1. Admin User (管理者) - role: admin
        // ========================================
        $admin = User::create([
            'role' => 'admin',
            'name' => '管理者 太郎',
            'email' => 'admin@admin.com',
            'phone' => '03-1234-5678',
            'postal_code' => '100-0001',
            'address' => '東京都千代田区千代田1-1',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // ========================================
        // 2. User WITHOUT Subscription (未登録ユーザー) - role: user
        // ========================================
        $noSubscriptionUser = User::create([
            'role' => 'user',
            'name' => '新規 ユーザー',
            'email' => 'new@demo.com',
            'phone' => '090-0000-0000',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        // No subscription for this user - just registered

        // ========================================
        // 3. Premium User (プレミアムプラン会員) - role: user
        // ========================================
        $premiumPlan = Plan::where('slug', 'premium')->first();
        
        $premiumUser = User::create([
            'role' => 'user',
            'name' => '田中 花子',
            'email' => 'premium@demo.com',
            'phone' => '090-1234-5678',
            'postal_code' => '150-0001',
            'address' => '東京都渋谷区神宮前1-2-3 渋谷マンション101',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        if ($premiumPlan) {
            // Active subscription
            $premiumSubscription = Subscription::create([
                'user_id' => $premiumUser->id,
                'plan_id' => $premiumPlan->id,
                'status' => 'active',
                'started_at' => now()->subMonths(3),
                'expires_at' => now()->addMonth(),
                'priority_reply' => true,
            ]);

            // Orders
            Order::create([
                'user_id' => $premiumUser->id,
                'type' => 'subscription',
                'item_name' => 'プレミアムプラン（月額）',
                'quantity' => 1,
                'unit_price' => 4980,
                'total_amount' => 4980,
                'status' => 'completed',
                'paid_at' => now()->subMonths(3),
                'completed_at' => now()->subMonths(3),
            ]);

            Order::create([
                'user_id' => $premiumUser->id,
                'type' => 'video_review',
                'item_name' => '動画添削（1本）',
                'quantity' => 1,
                'unit_price' => 3000,
                'total_amount' => 3000,
                'status' => 'completed',
                'paid_at' => now()->subWeeks(2),
                'completed_at' => now()->subWeeks(1),
            ]);

            // Payments
            Payment::create([
                'user_id' => $premiumUser->id,
                'subscription_id' => $premiumSubscription->id,
                'description' => 'プレミアムプラン 12月分',
                'amount' => 4980,
                'status' => 'paid',
                'billing_date' => now()->startOfMonth(),
                'paid_at' => now()->startOfMonth(),
                'payment_method' => 'credit_card',
            ]);

            Payment::create([
                'user_id' => $premiumUser->id,
                'subscription_id' => $premiumSubscription->id,
                'description' => 'プレミアムプラン 11月分',
                'amount' => 4980,
                'status' => 'paid',
                'billing_date' => now()->subMonth()->startOfMonth(),
                'paid_at' => now()->subMonth()->startOfMonth(),
                'payment_method' => 'credit_card',
            ]);

            Payment::create([
                'user_id' => $premiumUser->id,
                'subscription_id' => $premiumSubscription->id,
                'description' => 'プレミアムプラン 10月分',
                'amount' => 4980,
                'status' => 'paid',
                'billing_date' => now()->subMonths(2)->startOfMonth(),
                'paid_at' => now()->subMonths(2)->startOfMonth(),
                'payment_method' => 'credit_card',
            ]);

            // Downloads for premium user
            Download::create([
                'title' => '運営レポート 2024年12月',
                'description' => '12月のSNS運用状況と改善提案',
                'file_path' => 'reports/2024-12-report.pdf',
                'file_name' => '2024-12-report.pdf',
                'file_type' => 'pdf',
                'file_size' => 2048000,
                'category' => 'report',
                'user_id' => $premiumUser->id,
                'is_active' => true,
            ]);

            Download::create([
                'title' => '動画添削結果',
                'description' => '添削済み動画とフィードバック',
                'file_path' => 'deliverables/review-feedback-001.zip',
                'file_name' => 'review-feedback-001.zip',
                'file_type' => 'zip',
                'file_size' => 5120000,
                'category' => 'deliverable',
                'user_id' => $premiumUser->id,
                'is_active' => true,
            ]);
        }

        // ========================================
        // 4. Basic User (ベーシックプラン会員) - role: user
        // ========================================
        $basicPlan = Plan::where('slug', 'basic')->first();
        
        $basicUser = User::create([
            'role' => 'user',
            'name' => '鈴木 一郎',
            'email' => 'basic@demo.com',
            'phone' => '080-9876-5432',
            'postal_code' => '530-0001',
            'address' => '大阪府大阪市北区梅田2-3-4',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        if ($basicPlan) {
            Subscription::create([
                'user_id' => $basicUser->id,
                'plan_id' => $basicPlan->id,
                'status' => 'active',
                'started_at' => now()->subMonth(),
                'expires_at' => now()->addDays(15),
            ]);

            Order::create([
                'user_id' => $basicUser->id,
                'type' => 'subscription',
                'item_name' => 'ベーシックプラン（月額）',
                'quantity' => 1,
                'unit_price' => 1980,
                'total_amount' => 1980,
                'status' => 'completed',
                'paid_at' => now()->subMonth(),
                'completed_at' => now()->subMonth(),
            ]);

            Payment::create([
                'user_id' => $basicUser->id,
                'description' => 'ベーシックプラン 12月分',
                'amount' => 1980,
                'status' => 'paid',
                'billing_date' => now()->startOfMonth(),
                'paid_at' => now()->startOfMonth(),
                'payment_method' => 'credit_card',
            ]);
        }

        // ========================================
        // 5. Free User (無料会員 - 動画編集利用) - role: user
        // ========================================
        $freePlan = Plan::where('slug', 'free')->first();
        
        $freeUser = User::create([
            'role' => 'user',
            'name' => '山田 美咲',
            'email' => 'free@demo.com',
            'phone' => '070-1111-2222',
            'postal_code' => '460-0008',
            'address' => '愛知県名古屋市中区栄3-4-5',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        if ($freePlan) {
            Subscription::create([
                'user_id' => $freeUser->id,
                'plan_id' => $freePlan->id,
                'status' => 'active',
                'started_at' => now()->subWeeks(2),
            ]);

            // Video edit order
            Order::create([
                'user_id' => $freeUser->id,
                'type' => 'video_edit_5pack',
                'item_name' => '動画編集5本セット',
                'quantity' => 1,
                'unit_price' => 25000,
                'total_amount' => 25000,
                'status' => 'processing',
                'paid_at' => now()->subDays(3),
            ]);

            Payment::create([
                'user_id' => $freeUser->id,
                'description' => '動画編集5本セット',
                'amount' => 25000,
                'status' => 'paid',
                'billing_date' => now()->subDays(3),
                'paid_at' => now()->subDays(3),
                'payment_method' => 'bank_transfer',
            ]);
        }

        // ========================================
        // 6. Pending User (受付済 - 決済待ち) - role: user
        // ========================================
        $pendingUser = User::create([
            'role' => 'user',
            'name' => '佐藤 健太',
            'email' => 'pending@demo.com',
            'phone' => '090-3333-4444',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        if ($basicPlan) {
            Subscription::create([
                'user_id' => $pendingUser->id,
                'plan_id' => $basicPlan->id,
                'status' => 'pending',
            ]);

            Order::create([
                'user_id' => $pendingUser->id,
                'type' => 'subscription',
                'item_name' => 'ベーシックプラン（月額）',
                'quantity' => 1,
                'unit_price' => 1980,
                'total_amount' => 1980,
                'status' => 'pending',
                'payment_method' => 'bank_transfer',
            ]);

            Payment::create([
                'user_id' => $pendingUser->id,
                'description' => 'ベーシックプラン 初回',
                'amount' => 1980,
                'status' => 'pending',
                'billing_date' => now(),
                'due_date' => now()->addDays(7),
            ]);
        }

        // ========================================
        // 7. Cancelling User (解約申請中) - role: user
        // ========================================
        $cancellingUser = User::create([
            'role' => 'user',
            'name' => '高橋 真理',
            'email' => 'cancelling@demo.com',
            'phone' => '080-5555-6666',
            'postal_code' => '812-0011',
            'address' => '福岡県福岡市博多区博多駅前1-2-3',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        if ($premiumPlan) {
            Subscription::create([
                'user_id' => $cancellingUser->id,
                'plan_id' => $premiumPlan->id,
                'status' => 'cancelling',
                'started_at' => now()->subMonths(6),
                'expires_at' => now()->addDays(10),
                'cancelled_at' => now()->subDays(5),
                'cancel_reason' => '予算の都合により',
            ]);
        }

        // ========================================
        // 8. Cancelled User (解約済) - role: user
        // ========================================
        $cancelledUser = User::create([
            'role' => 'user',
            'name' => '伊藤 大輔',
            'email' => 'cancelled@demo.com',
            'phone' => '070-7777-8888',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        if ($basicPlan) {
            Subscription::create([
                'user_id' => $cancelledUser->id,
                'plan_id' => $basicPlan->id,
                'status' => 'cancelled',
                'started_at' => now()->subMonths(4),
                'expires_at' => now()->subMonth(),
                'cancelled_at' => now()->subMonth(),
                'cancel_reason' => 'サービス内容が期待と異なった',
            ]);
        }

        // ========================================
        // Public Downloads (全会員向け)
        // ========================================
        Download::create([
            'title' => 'FLOWGRAM利用ガイド',
            'description' => 'サービスの使い方を詳しく解説したガイドブック',
            'file_path' => 'guides/flowgram-guide.pdf',
            'file_name' => 'flowgram-guide.pdf',
            'file_type' => 'pdf',
            'file_size' => 1024000,
            'category' => 'guide',
            'is_public' => true,
            'is_active' => true,
        ]);

        Download::create([
            'title' => 'SNS運用チェックリスト',
            'description' => '日々のSNS運用に役立つチェックリスト',
            'file_path' => 'bonus/sns-checklist.pdf',
            'file_name' => 'sns-checklist.pdf',
            'file_type' => 'pdf',
            'file_size' => 512000,
            'category' => 'bonus',
            'is_public' => true,
            'is_active' => true,
        ]);

        // Premium-only downloads
        Download::create([
            'title' => 'Instagramアルゴリズム解説2024',
            'description' => '最新のInstagramアルゴリズムを徹底解説',
            'file_path' => 'bonus/ig-algorithm-2024.pdf',
            'file_name' => 'ig-algorithm-2024.pdf',
            'file_type' => 'pdf',
            'file_size' => 3072000,
            'category' => 'bonus',
            'plan_required' => 'premium',
            'is_active' => true,
        ]);

        // ========================================
        // Output Info
        // ========================================
        $this->command->info('');
        $this->command->info('✅ FLOWGRAM Users & Data created successfully!');
        $this->command->info('');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('📋 LOGIN CREDENTIALS (Password: password)');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('');
        $this->command->info('🔐 ADMIN (Admin Panel: /admin)');
        $this->command->info('   admin@admin.com');
        $this->command->info('');
        $this->command->info('👥 USERS (MyPage: /mypage)');
        $this->command->info('   ┌─────────────────────────────────────────────────────────────────┐');
        $this->command->info('   │ 未登録         new@demo.com          (Subscription なし)        │');
        $this->command->info('   ├─────────────────────────────────────────────────────────────────┤');
        $this->command->info('   │ ⭐ プレミアム   premium@demo.com      (提供中)                  │');
        $this->command->info('   │ 📦 ベーシック   basic@demo.com        (提供中)                  │');
        $this->command->info('   │ 🆓 無料会員     free@demo.com         (提供中)                  │');
        $this->command->info('   │ ⏳ 受付済       pending@demo.com      (決済待ち)                │');
        $this->command->info('   │ 🔄 解約申請中   cancelling@demo.com                             │');
        $this->command->info('   │ ❌ 解約済       cancelled@demo.com                              │');
        $this->command->info('   └─────────────────────────────────────────────────────────────────┘');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
    }
}
