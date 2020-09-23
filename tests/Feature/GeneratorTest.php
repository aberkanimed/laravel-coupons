<?php

namespace aberkanidev\Coupons\Tests;

use aberkanidev\Coupons\CouponGenerator;

class GeneratorTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function it_uses_the_specified_charachters_only()
    {
        $generator = new CouponGenerator('1234567890', '********');
        $coupon = $generator->generate();
        $this->assertMatchesRegularExpression('/^[0-9]/', $coupon);
    }

    /** @test */
    public function it_uses_the_specified_prefix()
    {
        $generator = new CouponGenerator();
        $generator->setPrefix('GIFT-');
        $coupon = $generator->generate();
        $this->assertStringStartsWith('GIFT-', $coupon);
    }

    /** @test */
    public function it_uses_the_specified_suffix()
    {
        $generator = new CouponGenerator();
        $generator->setSuffix('-GIFT');
        $coupon = $generator->generate();
        $this->assertStringEndsWith('-GIFT', $coupon);
    }

    /** @test */
    public function it_uses_the_custom_separator()
    {
        $generator = new CouponGenerator();
        $generator->setSeparator('%');
        $generator->setPrefix('aberkanidev');
        $generator->setSuffix('aberkanidev');
        $coupon = $generator->generate();
        $this->assertStringStartsWith('aberkanidev%', $coupon);
        $this->assertStringEndsWith('%aberkanidev', $coupon);
    }

    /** @test */
    public function it_generates_code_with_mask()
    {
        $generator = new CouponGenerator('ABCDEFGH', '* * * *');
        $coupon = $generator->generate();
        $this->assertMatchesRegularExpression('/(.*)\s(.*)\s(.*)\s(.*)/', $coupon);
    }
}