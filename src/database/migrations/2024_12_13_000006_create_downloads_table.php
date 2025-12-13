<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * ダウンロード資料テーブル
     */
    public function up(): void
    {
        Schema::create('downloads', function (Blueprint $table) {
            $table->id();
            $table->string('title');                     // ファイルタイトル
            $table->text('description')->nullable();     // 説明
            $table->string('file_path');                 // ファイルパス
            $table->string('file_name');                 // オリジナルファイル名
            $table->string('file_type');                 // ファイルタイプ (pdf, zip, etc.)
            $table->integer('file_size');                // ファイルサイズ (bytes)
            
            // カテゴリ
            $table->enum('category', [
                'guide',         // 利用ガイド
                'report',        // 運営レポート
                'bonus',         // 特典資料
                'deliverable',   // 成果物（編集済み動画等）
                'other'          // その他
            ])->default('other');
            
            // アクセス制限
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');  // 特定ユーザー向け
            $table->string('plan_required')->nullable(); // 必要プラン (basic, premium, null=全員)
            $table->boolean('is_public')->default(false); // 全員公開
            
            $table->boolean('is_active')->default(true);
            $table->integer('download_count')->default(0);
            
            $table->timestamps();
            
            $table->index(['user_id', 'is_active']);
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('downloads');
    }
};

