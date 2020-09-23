<?php

namespace aberkanidev\Coupons;

use aberkanidev\Coupons\Models\Coupon;
use aberkanidev\Coupons\CouponGenerator;
use Illuminate\Database\Eloquent\Model;
use aberkanidev\Coupons\Exceptions\CouponExpired;
use aberkanidev\Coupons\Exceptions\CouponIsInvalid;

class Coupons
{
    private $generator;

    public function __construct(CouponGenerator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Generate the specified amount of codes and return
     * an array with all the generated codes.
     *
     * @param int $amount
     * @return array
     */
    public function generate(int $amount = 1): array
    {
        $codes = [];

        for ($i = 1; $i <= $amount; $i++) {
            $codes[] = $this->getUniqueCoupon();
        }

        return $codes;
    }

    /**
     * @param Model $model
     * @param int $amount
     * @param array $data
     * @param null $expires_at
     * @return array
     */
    public function create(Model $model, int $amount = 1, array $data = [], bool $is_disposable = false, $expires_at = null)
    {
        $coupons = [];

        foreach ($this->generate($amount) as $couponCode) {
            $coupons[] = Coupon::create([
                'model_id' => $model->getKey(),
                'model_type' => $model->getMorphClass(),
                'code' => $couponCode,
                'data' => $data,
                'is_disposable' => $is_disposable,
                'expires_at' => $expires_at,
            ]);
        }

        return $coupons;
    }

    /**
     * @param string $code
     * @throws CouponIsInvalid
     * @throws CouponExpired
     * @return Coupon
     */
    public function check(string $code)
    {
        $coupon = Coupon::whereCode($code)->first();

        if ($coupon === null) {
            throw CouponIsInvalid::withCode($code);
        }
        if ($coupon->isExpired()) {
            throw CouponExpired::create($coupon);
        }

        return $coupon;
    }

    /**
     * @return string
     */
    protected function getUniqueCoupon(): string
    {
        $coupon = $this->generator->generateUnique();

        while (Coupon::whereCode($coupon)->count() > 0) {
            $coupon = $this->generator->generateUnique();
        }

        return $coupon;
    }
}