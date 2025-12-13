<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 申込履歴テーブル
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->nullable()->unique();  // 注文番号 (auto-generated)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // 商品タイプ
            $table->enum('type', [
                'subscription',      // サブスクリプション
                'video_review',      // 動画添削
                'counseling',        // 個別カウンセリング
                'video_edit_single', // 単品動画編集
                'video_edit_5pack',  // 5本セット
                'video_edit_10pack', // 10本セット
                'priority_reply',    // 優先返信オプション
                'other'              // その他
            ]);
            
            $table->string('item_name');               // 商品名
            $table->text('item_description')->nullable();
            $table->integer('quantity')->default(1);   // 数量
            $table->integer('unit_price');             // 単価
            $table->integer('total_amount');           // 合計金額
            
            // 決済情報
            $table->enum('payment_method', [
                'credit_card',
                'bank_transfer',
                'other'
            ])->default('credit_card');
            
            // ステータス
            $table->enum('status', [
                'pending',      // 受付済
                'confirmed',    // 決済確認済
                'processing',   // 処理中
                'completed',    // 完了
                'cancelled',    // キャンセル
                'refunded'      // 返金済
            ])->default('pending');
            
            $table->timestamp('paid_at')->nullable();      // 決済確認日時
            $table->timestamp('completed_at')->nullable(); // 完了日時
            
            $table->text('admin_notes')->nullable();       // 管理者メモ
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index('order_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

