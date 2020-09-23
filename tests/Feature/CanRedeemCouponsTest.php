<?php

namespace aberkanidev\Coupons\Tests;

use Event;
use Coupons;
use aberkanidev\Coupons\Tests\Models\Item;
use aberkanidev\Coupons\Tests\Models\User;
use aberkanidev\Coupons\Tests\Models\Gifter;
use aberkanidev\Coupons\Events\CouponRedeemed;
use aberkanidev\Coupons\Exceptions\CouponExpired;
use aberkanidev\Coupons\Exceptions\CouponIsInvalid;
use aberkanidev\Coupons\Exceptions\CouponAlreadyRedeemed;

class CanRedeemCouponsTest extends TestCase
{
    /** @test */
    public function it_throws_an_invalid_coupon_exception_for_invalid_codes()
    {
        $this->expectException(CouponIsInvalid::class);

        $user = User::first();

        $user->redeemCode('invalid');
    }

    /** @test */
    public function a_user_can_redeem_coupons_code()
    {
        $user = User::find(1);
        $item = Item::create(['name' => 'Foo']);

        $coupons = Coupons::create($item);
        $coupon = $coupons[0];

        $user->redeemCode($coupon->code);

        $this->assertCount(1, $user->coupons);

        $userCoupons = $user->coupons()->first();
        $this->assertNotNull($userCoupons->redeemed_at);
    }

    /** @test */
    public function a_user_can_not_redeem_single_use_coupon_twice()
    {
        $this->expectException(CouponAlreadyRedeemed::class);

        $user = User::find(1);
        $item = Item::create(['name' => 'Foo']);

        $coupons = Coupons::create($item, 1, [], true);
        $coupon = $coupons[0];

        $user->redeemCode($coupon->code);
        $user->redeemCode($coupon->code);
    }

    /** @test */
    public function a_user_can_not_redeem_multiple_use_coupon_twice()
    {
        $this->expectException(CouponAlreadyRedeemed::class);

        $user = User::find(1);
        $item = Item::create(['name' => 'Foo']);

        $coupons = Coupons::create($item, 1, [], false);
        $coupon = $coupons[0];

        $user->redeemCode($coupon->code);
        $user->redeemCode($coupon->code);
    }

    /** @test */
    public function multiple_use_coupon_can_be_redeemed_by_two_users()
    {
        $user = User::find(1);
        $gifter = Gifter::create(['name' => 'Mohamed']);
        $item = Item::create(['name' => 'Foo']);

        $coupons = Coupons::create($item, 1, [], false);
        $coupon = $coupons[0];

        $user->redeemCode($coupon->code);
        $gifter->redeemCode($coupon->code);

        $this->assertCount(1, $user->coupons);
        $this->assertCount(1, $gifter->coupons);

        $userCoupons = $user->coupons()->first();
        $gifterCoupons = $gifter->coupons()->first();
        $this->assertNotNull($userCoupons->redeemed_at);
        $this->assertNotNull($gifterCoupons->redeemed_at);
    }

    /** @test */
    public function a_user_can_not_redeem_expired_coupons()
    {
        $this->expectException(CouponExpired::class);

        $user = User::find(1);
        $item = Item::create(['name' => 'Foo']);

        $coupons = Coupons::create($item, 1, [], false, today()->subDay());
        $coupon = $coupons[0];

        $user->redeemCode($coupon->code);
    }

    /** @test */
    public function users_can_redeem_coupon_models()
    {
        $user = User::find(1);
        $item = Item::create(['name' => 'Foo']);

        $coupons = Coupons::create($item);
        $coupon = $coupons[0];

        $user->redeemCoupon($coupon);

        $this->assertCount(1, $user->coupons);

        $userCoupons = $user->coupons()->first();
        $this->assertNotNull($userCoupons->redeemed_at);
    }

    /** @test */
    public function redeeming_coupons_fires_an_event()
    {
        Event::fake();

        $user = User::find(1);
        $item = Item::create(['name' => 'Foo']);

        $coupons = Coupons::create($item);
        $coupon = $coupons[0];

        $user->redeemCoupon($coupon);

        Event::assertDispatched(CouponRedeemed::class, function ($e) use ($user, $coupon) {
            return $e->user->id === $user->id && $e->voucher->id === $coupon->id;
        });
    }
}