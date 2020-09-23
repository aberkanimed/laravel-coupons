<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $couponTable = config('coupons.table', 'coupons');
        $voucherable = config('coupons.voucherable_table', 'voucherables');

        Schema::create($couponTable, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 32)->unique();
            $table->morphs('model');
            $table->text('data')->nullable();
            $table->boolean('is_disposable');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        Schema::create($voucherable, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('model');
            $table->unsignedBigInteger('coupon_id');
            $table->timestamp('redeemed_at');
            $table->timestamps();

            $table->foreign('coupon_id')->references('id')->on('coupons');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists(config('coupons.table', 'coupons'));
        Schema::dropIfExists(config('coupons.voucherable_table', 'voucherables'));
    }
}