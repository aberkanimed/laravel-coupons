<?php

namespace aberkanidev\Coupons\Events;

use Illuminate\Queue\SerializesModels;
use aberkanidev\Coupons\Models\Coupon;

class CouponRedeemed
{
    use SerializesModels;

    public $user;

    /** @var Coupon */
    public $coupon;

    public function __construct($user, Coupon $coupon)
    {
        $this->user = $user;
        $this->voucher = $coupon;
    }
}
