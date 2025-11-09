<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // 商品レビュー用のカラムをNULL許容に変更
            $table->string('title')->nullable()->change();
            $table->text('content')->nullable()->change();
            $table->unsignedBigInteger('product_id')->nullable()->change();

            // 店舗レビュー用カラムを追加
            if (!Schema::hasColumn('reviews', 'store_id')) {
                $table->unsignedBigInteger('store_id')->nullable()->after('product_id');
            }
            if (!Schema::hasColumn('reviews', 'comment')) {
                $table->text('comment')->nullable()->after('store_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->string('title')->nullable(false)->change();
            $table->text('content')->nullable(false)->change();
            $table->unsignedBigInteger('product_id')->nullable(false)->change();

            $table->dropColumn('store_id');
            $table->dropColumn('comment');
        });
    }
};
