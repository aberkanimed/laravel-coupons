<?php

namespace aberkanidev\Coupons\Exceptions;

class CouponIsInvalid extends \Exception
{
    protected $code;

    public static function withCode(string $code)
    {
        return new static('The provided code ' . $code . ' is invalid.', $code);
    }

    public function __construct($message, $code)
    {
        $this->message = $message;
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getCouponCode()
    {
        return $this->code;
    }
}
