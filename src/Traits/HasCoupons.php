<?php

namespace aberkanidev\Coupons\Traits;

use aberkanidev\Coupons\Models\Coupon;
use aberkanidev\Coupons\Facades\Coupons;

trait HasCoupons
{
    /**
     * Set the polymorphic relation.
     *
     * @return mixed
     */
    public function coupons()
    {
        return $this->morphMany(Coupon::class, 'model');
    }

    /**
     * @param int $amount
     * @param array $data
     * @param null $expires_at
     * @return Coupon[]
     */
    public function createCoupons(int $amount, array $data = [], bool $is_disposable = false, $expires_at = null)
    {
        return Coupons::create($this, $amount, $data, $is_disposable, $expires_at);
    }

    /**
     * @param array $data
     * @param null $expires_at
     * @return Coupon
     */
    public function createCoupon(array $data = [], bool $is_disposable = false, $expires_at = null)
    {
        return $this->createCoupons(1, $data, $is_disposable, $expires_at)[0];
    }

    public function createDisposableCoupon(array $data = [], bool $is_disposable = true, $expires_at = null)
    {
        return $this->createCoupons(1, $data, $is_disposable, $expires_at)[0];
    }
}