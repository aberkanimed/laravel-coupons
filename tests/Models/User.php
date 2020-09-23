<?php

namespace aberkanidev\Coupons\Tests\Models;

use aberkanidev\Coupons\Traits\CanRedeemCoupons;

class User extends \Illuminate\Foundation\Auth\User
{
    use CanRedeemCoupons;
}
