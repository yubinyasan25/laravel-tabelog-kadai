<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('number_of_people');    // 予約人数
            $table->dateTime('reservation_datetime'); // 予約日時
            $table->foreignId('store_id')->constrained()->onDelete('cascade'); // 店舗ID
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ユーザーID
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
};
