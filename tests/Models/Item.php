<?php

namespace aberkanidev\Coupons\Tests\Models;

use aberkanidev\Coupons\Traits\HasCoupons;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasCoupons;
    protected $fillable = ['name'];
}
