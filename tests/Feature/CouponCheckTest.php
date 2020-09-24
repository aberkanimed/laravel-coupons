<?php

namespace aberkanidev\Coupons\Tests;

use Event;
use Coupons;
use aberkanidev\Coupons\Tests\Models\Item;
use aberkanidev\Coupons\Tests\Models\User;
use aberkanidev\Coupons\Exceptions\CouponExpired;
use aberkanidev\Coupons\Exceptions\CouponIsInvalid;
use aberkanidev\Coupons\Exceptions\CouponAlreadyRedeemed;
use aberkanidev\Coupons\Exceptions\VoucherableModelNotFound;

class CouponCheckTest extends TestCase
{
    /** @test */
    public function it_throws_an_invalid_coupon_exception()
    {
        $this->expectException(CouponIsInvalid::class);
        Coupons::check('invalid');
    }

    /** @test */
    public function it_throws_a_coupon_expired_exception()
    {
        $this->expectException(CouponExpired::class);

        $item = Item::create(['name' => 'Foo']);

        $coupons = Coupons::create($item, 1, [], false, today()->subDay());
        $coupon = $coupons[0];

        Coupons::check($coupon->code);
    }

    /** @test */
    public function it_throws_a_coupon_already_redeemed_exception_for_disposable_coupons()
    {
        $this->expectException(CouponAlreadyRedeemed::class);

        $user = User::find(1);
        $item = Item::create(['name' => 'Foo']);

        $coupons = Coupons::create($item, 1, [], true);
        $coupon = $coupons[0];

        $user->redeemCode($coupon->code);
        Coupons::check($coupon->code);
    }

    /** @test */
    public function it_throws_a_coupon_already_redeemed_exception_for_no_disposable_coupons()
    {
        $this->expectException(CouponAlreadyRedeemed::class);

        $user = User::find(1);
        $item = Item::create(['name' => 'Foo']);

        $coupons = Coupons::create($item, 1, [], false);
        $coupon = $coupons[0];

        $user->redeemCode($coupon->code);
        Coupons::check($coupon->code, $user);
    }

    /** @test */
    public function it_throws_a_voucherable_not_found_exception_when_no_model_passed_to_check_for_no_diposable_coupons()
    {
        $this->expectException(VoucherableModelNotFound::class);

        $user = User::find(1);
        $item = Item::create(['name' => 'Foo']);

        $coupons = Coupons::create($item, 1, [], false);
        $coupon = $coupons[0];

        $user->redeemCode($coupon->code);
        Coupons::check($coupon->code);
    }


}
