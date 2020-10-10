# Laravel Coupons

Laravel coupons is a package that allows you to add coupons system to your laravel app. The coupons can be associated with Eloquent models, and they can be redeemed by any Eloquent model you choose, not only User model.

Here is an example:

```php
$item = Item::find(1);
$customer = Customer::find(1);

$coupon = $Item->createDisposableCoupon();

$customer->redeemCoupon($coupon);
```

## Table of content

- [Installation](notion://www.notion.so/aberkanimed/Laravel-Coupons-ea13b3f2c1014d94a87356786eb6db72#installation)
- [Usage](notion://www.notion.so/aberkanimed/Laravel-Coupons-ea13b3f2c1014d94a87356786eb6db72#usage)
- [License](notion://www.notion.so/aberkanimed/Laravel-Coupons-ea13b3f2c1014d94a87356786eb6db72#license)

## Installation

Install the package via composer

```bash
composer require aberkanidev/laravel-coupons
```

To publish the migration run:

```bash
php artisan vendor:publish --provider="aberkanidev\Coupons\CouponsServiceProvider" --tag="migrations"
```

To publish config file run:

```bash
php artisan vendor:publish --provider="aberkanidev\Coupons\CouponsServiceProvider" --tag="config"
```

Config file example:

```php
<?php

return [

    /*
     * Database table name that will be used in migration
     */
    'table' => 'coupons',

    /*
     * Database table name for voucherable models
     */
    'voucherable_table' => 'voucherables',

    /*
     * List of characters that will be used for coupon code generation.
     */
    'characters' => '23456789ABCDEFGHJKLMNPQRSTUVWXYZ',

    /*
     * Coupon code prefix.
     *
     * Example: foo
     * Generated Code: foo-AGXF-1NH8
     */
    'prefix' => null,

    /*
     * Coupon code suffix.
     *
     * Example: foo
     * Generated Code: AGXF-1NH8-foo
     */
    'suffix' => null,

    /*
     * Code mask.
     * All asterisks will be removed by random characters.
     */
    'mask' => '****-****',

    /*
     * Separator to be used between prefix, code and suffix.
     */
    'separator' => '-',
];
```

## Usage

To use this package you have to add this trait `aberkanidev\Coupons\Traits\HasCoupons` to the Eloquent models that will be associated to coupons.

Also, you have to add `aberkanidev\Coupons\Traits\CanRedeemCoupons` to the Eloquent models that can redeem coupons (For example: User, Customer, ...).

### Create coupons

Code example:

```php
$item = Item::find(1);

// Create 10 coupons using the Facade
// Returns an array of Coupons
$coupons = Coupons::create($item, 5);

// Create 3 coupons using the Eloquent model
// Returns an array of Coupons
$coupons = $item->createCoupons(2);

// Create a single coupon
$coupons = $item->createCoupon();

```

### Create disposable Coupon

```php
$item = Item::find(1);

// Create a disposable coupon
$coupon = $item->createDisposableCoupon();
```

### Create Coupons with additional data

```php
$item = Item::find(1);

$coupons = $item->createCoupons(4, [
    'amount' => '150',
    'recipient_name' => 'Mohamed Aberkani'
		'recipient_email' => 'aberkanidev@gmail.com'
]);

$coupons = $coupons[0];
$coupon->data->get('amount');
$coupon->data->get('recipient_name');
$coupon->data->get('recipient_email');
```

### Create Coupons with expiry dates:

```php
$item = Item::find(1);

$item->createCoupons(4, [], today()->addDays(3));
```

### Redeem Coupon code

You have two ways to redeem a coupons, using the code, or the Coupon Model

```php
$customer = Customer::find(1);

// Redeem using the code
// Returns the Coupon model
$coupon = $customer->redeem('ABCD-EFGH');
```

If the code is valid it will return the Coupon model.

### Redeem Coupon model

```php
$customer = Customer::find(1);

$item = Item::find(1);

// Create Coupon
$coupon = $item->createCoupon();

// Redeem the Coupon Model
$coupon = $customer->redeemCoupon($coupon);
```

This action (redeeming coupons) fires `aberkanidev\Coupons\Events\CouponRedeemed` event.

### Access the model associated to the Coupon model

```php
$customer = Customer::find(1);
$coupon = $customer->redeemCoupon('ABCD-EFGH');

$item = $coupon->model
```

## License

Laravel coupons is licensed under a [MIT License](https://github.com/aberkanimed/laravel-coupons/blob/master/LICENSE.md).
