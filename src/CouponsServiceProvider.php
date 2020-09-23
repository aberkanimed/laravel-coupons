<?php

namespace aberkanidev\Coupons;

use aberkanidev\Coupons\Coupons;
use Illuminate\Support\ServiceProvider;

class CouponsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('coupons.php'),
            ], 'config');

            if (!class_exists('CreateCouponsTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_coupons_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_coupons_table.php'),
                ], 'migrations');
            }
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'coupons');

        $this->app->singleton('coupons', function ($app) {
            $generator = new CouponGenerator(config('coupons.characters'), config('coupons.mask'));
            $generator->setPrefix(config('coupons.prefix'));
            $generator->setSuffix(config('coupons.suffix'));
            $generator->setSeparator(config('coupons.separator'));
            return new Coupons($generator);
        });
    }
}
