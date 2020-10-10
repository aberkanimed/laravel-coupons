# Laravel Coupons

# Description

Laravel coupons is a package that allows you to add coupons system to your laravel app. The coupons can be associated with Eloquent models, and they can be redeemed by any Eloquent model you choose, not only User model.

Here is an example:

```php
$item = Item::find(1);
$customer = Customer::find(1);

$coupon = $Item->createDisposableCoupon();

$customer->redeemCoupon($coupon);
```

# Table of content
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

# Installation

# Usage

# Contributing

# License
