<?php

namespace aberkanidev\Coupons\Tests\Models;

use aberkanidev\Coupons\Traits\CanRedeemCoupons;
use Illuminate\Database\Eloquent\Model;

class Gifter extends Model
{
    use CanRedeemCoupons;
    protected $fillable = ['name'];
}
