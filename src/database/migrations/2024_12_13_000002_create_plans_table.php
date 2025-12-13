<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * プラン管理テーブル
     */
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');                    // プラン名 (ベーシック, プレミアム, 無料会員)
            $table->string('slug')->unique();          // URL用スラッグ
            $table->text('description')->nullable();   // プラン説明
            $table->integer('price');                  // 月額料金（円）
            $table->json('features')->nullable();      // 機能リスト (JSON)
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // デフォルトプランを挿入
        DB::table('plans')->insert([
            [
                'name' => '無料会員',
                'slug' => 'free',
                'description' => '動画編集のみ利用可能',
                'price' => 0,
                'features' => json_encode(['動画編集サービス利用可能']),
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ベーシックプラン',
                'slug' => 'basic',
                'description' => '平日10:00〜17:00 無制限チャット相談',
                'price' => 1980,
                'features' => json_encode([
                    '無制限チャット相談',
                    '投稿の添削・アドバイス',
                    '企画・方向性相談',
                    'アルゴリズム情報の共有'
                ]),
                'is_active' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'プレミアムプラン',
                'slug' => 'premium',
                'description' => 'ベーシック＋月1回の運営レポート付き',
                'price' => 4980,
                'features' => json_encode([
                    'ベーシックプランの全機能',
                    '月1回の運営レポート',
                    'データ分析・改善提案',
                    '戦略立案サポート'
                ]),
                'is_active' => true,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};

