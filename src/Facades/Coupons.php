<?php

namespace aberkanidev\Coupons\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \aberkanidev\Coupons\CouponsClass
 */
class Coupons extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'coupons';
    }
}
