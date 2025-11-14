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
        Schema::table('users', function (Blueprint $table) {
    if (!Schema::hasColumn('users', 'stripe_customer_id')) {
        $table->string('stripe_customer_id')->nullable();
    }
    if (!Schema::hasColumn('users', 'stripe_subscription_id')) {
        $table->string('stripe_subscription_id')->nullable();
    }
    if (!Schema::hasColumn('users', 'stripe_payment_method_id')) {
        $table->string('stripe_payment_method_id')->nullable();
    }
    if (!Schema::hasColumn('users', 'is_paid_member')) {
        $table->boolean('is_paid_member')->default(false);
    }
});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
             $table->dropColumn([
                'stripe_customer_id',
                'stripe_subscription_id',
                'stripe_payment_method_id',
                'is_paid_member',
            ]);
        });
    }
};
