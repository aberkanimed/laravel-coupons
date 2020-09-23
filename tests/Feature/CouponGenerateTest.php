<?php

namespace aberkanidev\Coupons\Tests;

use Coupons;

class CouponGenerateTest extends TestCase
{
    /** @test */
    public function it_returns_an_array_of_one_code()
    {
        $codes = Coupons::generate();
        $this->assertCount(1, $codes);
    }

    /** @test */
    public function it_returns_an_array_of_multiple_codes()
    {
        $codes = Coupons::generate(5);
        $this->assertCount(5, $codes);
    }
}