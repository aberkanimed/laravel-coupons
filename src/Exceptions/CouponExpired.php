<?php

namespace aberkanidev\Coupons\Exceptions;

use aberkanidev\Coupons\Models\Coupon;

class CouponExpired extends \Exception
{
    protected $message = 'The coupon is already expired.';

    protected $coupon;

    public static function create(Coupon $coupon)
    {
        return new static($coupon);
    }

    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }
}