<?php

namespace aberkanidev\Coupons\Tests;

use Coupons;
use aberkanidev\Coupons\Models\Coupon;
use aberkanidev\Coupons\Tests\Models\Item;

class CouponCreateTest extends TestCase
{
    /** @test */
    public function it_creates_coupons_in_the_database_and_associates_them_with_the_model()
    {
        $item = Item::create(['name' => 'Foo']);

        $coupons = Coupons::create($item);

        $this->assertCount(1, $coupons);

        $coupon = $coupons[0];
        $this->assertInstanceOf(Coupon::class, $coupon);
        $this->assertSame($item->id, $coupon->model->id);
        $this->assertSame($item->name, $coupon->model->name);
        $this->assertInstanceOf(Item::class, $coupon->model);
    }

    /** @test */
    public function it_can_add_additional_data_to_a_coupon()
    {
        $item = Item::create(['name' => 'Foo']);

        $coupons = Coupons::create($item, 1, ['custom_information' => 'possible']);

        $coupon = $coupons[0];
        $this->assertSame('possible', $coupon->data->get('custom_information'));
    }
}
