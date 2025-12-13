<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * お問い合わせテーブル
     */
    public function up(): void
    {
        Schema::create('contact_inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            // 相談内容（複数選択可能）
            $table->json('topics');  // ['sns', 'review', 'edit', 'counseling', 'subscription', 'other']
            
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject');
            $table->text('message');
            
            // ステータス
            $table->enum('status', [
                'new',          // 新規
                'in_progress',  // 対応中
                'waiting',      // 返信待ち
                'resolved',     // 解決済み
                'closed'        // クローズ
            ])->default('new');
            
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->text('admin_notes')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            
            $table->timestamps();
            
            $table->index('status');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_inquiries');
    }
};

