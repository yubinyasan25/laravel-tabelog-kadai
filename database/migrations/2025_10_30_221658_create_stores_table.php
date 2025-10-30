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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');                 // 店舗名
            $table->text('description')->nullable(); // 店舗紹介
            $table->string('address')->nullable();   // 住所
            $table->string('image')->nullable();     // 画像
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // カテゴリID
            $table->boolean('recommend_flag')->default(false); // おすすめフラグ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
