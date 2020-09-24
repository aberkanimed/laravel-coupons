<?php

namespace aberkanidev\Coupons\Traits;

use Coupons;
use aberkanidev\Coupons\Models\Coupon;
use aberkanidev\Coupons\Models\Voucherable;
use aberkanidev\Coupons\Events\CouponRedeemed;
use aberkanidev\Coupons\Exceptions\CouponExpired;
use aberkanidev\Coupons\Exceptions\CouponAlreadyRedeemed;

trait CanRedeemCoupons
{
    /**
     * @param string $code
     * @throws CouponExpired
     * @throws CouponIsInvalid
     * @throws CouponAlreadyRedeemed
     * @return mixed
     */
    public function redeemCode(string $code)
    {
        $coupon = Coupons::check($code, $this);

        $this->createVoucherable($coupon);

        event(new CouponRedeemed($this, $coupon));

        return $coupon;
    }

    /**
     * @param Coupon $coupon
     * @throws CouponExpired
     * @throws CouponIsInvalid
     * @throws CouponAlreadyRedeemed
     * @return mixed
     */
    public function redeemCoupon(Coupon $coupon)
    {
        return $this->redeemCode($coupon->code);
    }

    /**
     * Set the polymorphic relation.
     *
     * @return mixed
     */
    public function coupons()
    {
        return $this->morphMany(Voucherable::class, 'model');
    }

    /**
     *
     * @param Coupon $coupon
     * @return void
     */
    protected function createVoucherable(Coupon $coupon) {
        Voucherable::create([
            'model_id' => $this->getKey(),
            'model_type' => $this->getMorphClass(),
            'coupon_id' => $coupon->id,
            'redeemed_at' => now()
        ]);
    }
}