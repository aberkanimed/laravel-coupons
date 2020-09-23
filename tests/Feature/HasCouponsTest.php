<?php

namespace aberkanidev\Coupons\Tests;

use Coupons;
use aberkanidev\Coupons\Tests\Models\Item;

class HasCouponsTest extends TestCase
{
    /** @test */
    public function models_with_coupons_can_access_them()
    {
        $item = Item::create(['name' => 'Foo']);
        $this->assertCount(0, $item->coupons()->get());
        Coupons::create($item, 10);
        $this->assertCount(10, $item->coupons()->get());
    }

    /** @test */
    public function models_can_create_coupons_associated_to_them()
    {
        $item = Item::create(['name' => 'Foo']);
        $coupon = $item->createCoupon();
        $this->assertCount(1, $item->coupons()->get());
        $this->assertSame($coupon->model->id, $item->id);
    }

    /** @test */
    public function models_can_create_disposable_coupon_associated_to_them()
    {
        $item = Item::create(['name' => 'Foo']);
        $coupon = $item->createDisposableCoupon();
        $this->assertCount(1, $item->coupons()->get());
        $this->assertSame($coupon->model->id, $item->id);
        $this->assertTrue($coupon->is_disposable);
    }

    /** @test */
    public function models_can_create_multiple_coupons_associated_to_them()
    {
        $item = Item::create(['name' => 'Foo']);
        $coupons = $item->createCoupons(2);

        $this->assertCount(2, $item->coupons()->get());

        $this->assertSame($coupons[0]->model->id, $item->id);
        $this->assertSame($coupons[1]->model->id, $item->id);
    }
}