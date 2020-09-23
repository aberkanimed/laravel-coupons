<?php

namespace aberkanidev\Coupons\Models;

use Illuminate\Database\Eloquent\Model;

class Voucherable extends Model
{
    protected $fillable = [
        'model_id',
        'model_type',
        'coupon_id',
        'redeemed_at'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('coupons.voucherable_table', 'voucherables');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model()
    {
        return $this->morphTo();
    }
}
