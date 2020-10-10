<?php

namespace aberkanidev\Coupons\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use aberkanidev\Coupons\Exceptions\VoucherableModelNotFound;

class Coupon extends Model
{
    protected $fillable = [
        'model_id',
        'model_type',
        'code',
        'data',
        'is_disposable',
        'expires_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'expires_at'
    ];

    protected $casts = [
        'data' => 'collection'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('coupons.table', 'coupons');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model()
    {
        return $this->morphTo();
    }

    /**
     * Check if code is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->expires_at ? Carbon::now()->gte($this->expires_at) : false;
    }

    /**
     *
     * @param $model
     * @return boolean
     */
    public function isRedeemed()
    {
        return Voucherable::where('coupon_id', $this->id)->exists();
    }

    /**
     *
     * @param $model
     * @return boolean
     */
    public function isRedeemedBy($model)
    {
        if($model == null) {
            throw VoucherableModelNotFound::create();
        }

        return Voucherable::where([
            ['coupon_id', $this->id],
            ['model_id', $model->id],
            ['model_type', $model->getMorphClass()]
        ])->exists();
    }
}
