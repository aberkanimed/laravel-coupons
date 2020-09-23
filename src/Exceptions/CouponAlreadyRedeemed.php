<?php

namespace aberkanidev\Coupons\Exceptions;

use aberkanidev\Coupons\Models\Coupon;

class CouponAlreadyRedeemed extends \Exception
{
    protected $message = 'The coupon was already redeemed.';

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