<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // store_idカラムを追加（unsignedBigIntegerで、storesテーブルのidと紐付け）
            $table->unsignedBigInteger('store_id')->after('id');

            // 外部キー制約を追加
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // 外部キー制約を削除
            $table->dropForeign(['store_id']);

            // カラム削除
            $table->dropColumn('store_id');
        });
    }
};
