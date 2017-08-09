# Adsmurai Currency Library

[![Build Status](https://travis-ci.org/Adsmurai/Currency.svg?branch=master)](https://travis-ci.org/Adsmurai/Currency)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Adsmurai/Currency/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Adsmurai/Currency/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Adsmurai/Currency/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Adsmurai/Currency/?branch=master)

## Introduction

The Adsmurai Currency library has been developed to solve some currency and
architecture related problems:

  * Currency data centralization
  * Values encapsulation
  * Representation
  * Extra precision to represent very small currency amounts.
  * Conversions

## Setup

Install it through composer, that's it:
```bash
composer install adsmurai/currency
```

## Code examples

```php
<?php

use Adsmurai\Currency\Contracts\Currency;
use Adsmurai\Currency\CurrencyFactory;
use Adsmurai\Currency\MoneyFactoriesLocator;
use Adsmurai\Currency\MoneyFactory;

// This factory will create Currency objects given the currency ISO code.
// By default, it will load the currency data from a library's internal data
// source, but we can use alternative data sources.
$currencyFactory = CurrencyFactory::fromDataPath();
$currencyFactory = CurrencyFactory::fromDataArray([
    'EUR' => [
        'numFractionalDigits' => 2,
        'symbol' => '€',
        'symbolPlacement' => Currency::AFTER_PLACEMENT,
    ],
    'USD' => [
        'numFractionalDigits' => 2,
        'symbol' => '$',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ]
]);

// This factory will create Money objects with the same currency type.
// The rationale behind this class is that almost always we'll work with the
// same currency type.
$moneyFactory = new MoneyFactory(
    $currencyFactory->buildFromISOCode('EUR')
);

// In fact, to avoid introducing hard dependencies on the factory implementation
// through the instantiation (via the `new` operator), we recommend to obtain
// the `MoneyFactory` instances through the `MoneyFactoriesLocator`.
//
// This will have some advantages:
//   * We can inject instances of the `MoneyFactoriesLocator` contract in our
//     domain logic without having to rely on specific implementations.
//   * We can avoid `MoneyFactory` instances proliferation, since this
//     factories locator keeps one single instances per currency ISO code.
$moneyFactoriesLocator = new MoneyFactoriesLocator($currencyFactory);
$moneyFactory = $moneyFactoriesLocator->getMoneyFactory('EUR');

// We have many ways to construct Money objects, depending on the data we
// have at the time.
$money = $moneyFactory->buildFromString('10.57');
$money = $moneyFactory->buildFromFloat(10.57);
$money = $moneyFactory->buildFromFractionalUnits(1057);

// If we want to format a currency value, we can use a specific method, that
// will take into account the number of digits, symbol, symbol placement...
echo $money->format();


```

## Troubleshooting

We haven't faced any interesting problem related with this library, if you are
struggling to make it work, open an issue on the issue tracker (and we'll update
this section).
