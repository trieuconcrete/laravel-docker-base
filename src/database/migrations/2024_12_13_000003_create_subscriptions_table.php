<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * ユーザーサブスクリプション管理テーブル
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained()->onDelete('restrict');
            
            // ステータス: pending(受付済), confirmed(決済確認済), active(提供中), 
            //            cancelling(解約申請中), cancelled(解約済), expired(期限切れ)
            $table->enum('status', [
                'pending',      // 受付済
                'confirmed',    // 決済確認済
                'active',       // 提供中
                'cancelling',   // 解約申請中
                'cancelled',    // 解約済
                'expired'       // 期限切れ
            ])->default('pending');
            
            $table->date('started_at')->nullable();          // サービス開始日
            $table->date('expires_at')->nullable();          // 次回更新日/有効期限
            $table->date('cancelled_at')->nullable();        // 解約申請日
            $table->text('cancel_reason')->nullable();       // 解約理由
            
            // オプション
            $table->boolean('priority_reply')->default(false);  // 優先返信オプション
            
            $table->text('admin_notes')->nullable();         // 管理者メモ
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};

