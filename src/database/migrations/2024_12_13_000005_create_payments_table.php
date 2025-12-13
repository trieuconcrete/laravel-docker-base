<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 請求・支払い履歴テーブル
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('subscription_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('payment_number')->nullable()->unique();  // 請求番号 (auto-generated)
            $table->string('description');               // 請求内容
            $table->integer('amount');                   // 請求金額
            
            // ステータス
            $table->enum('status', [
                'pending',    // 請求中
                'paid',       // 支払済
                'overdue',    // 延滞
                'cancelled',  // キャンセル
                'refunded'    // 返金済
            ])->default('pending');
            
            $table->date('billing_date');                // 請求日
            $table->date('due_date')->nullable();        // 支払期限
            $table->timestamp('paid_at')->nullable();    // 支払日時
            
            $table->enum('payment_method', [
                'credit_card',
                'bank_transfer',
                'other'
            ])->nullable();
            
            $table->text('admin_notes')->nullable();     // 管理者メモ
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index('billing_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

