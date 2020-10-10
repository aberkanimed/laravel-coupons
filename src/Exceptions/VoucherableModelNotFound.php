<?php

namespace aberkanidev\Coupons\Exceptions;

use aberkanidev\Coupons\Models\Coupon;

class VoucherableModelNotFound extends \Exception
{
    public static function create()
    {
        return new static('Voucherable Model not found');
    }

    public function __construct($message)
    {
        $this->message = $message;
    }
}
