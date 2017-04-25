# Adsmurai Currency Library

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

Meanwhile this project is closed source, you'll need to add the repository data
to the `composer.json`'s `respositories` key:
```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "git@bitbucket.org:adsmurai/currency.git"
    }
  ]
}
```

## Code examples

```php
<?php

use Adsmurai\Currency\Contracts\CurrencyType;
use Adsmurai\Currency\CurrencyFactory;
use Adsmurai\Currency\CurrencyTypeFactory;

// This factory will create CurrencyType objects given the currency ISO code.
// By default, it will load the currency data from a library's internal data
// source, but we can use alternative data sources.
$currencyTypeFactory = CurrencyTypeFactory::fromDataPath();
$currencyTypeFactory = CurrencyTypeFactory::fromDataArray([
    'EUR' => [
        'numFractionalDigits' => 2,
        'symbol' => '€',
        'symbolPlacement' => CurrencyType::AFTER_PLACEMENT,
    ],
    'USD' => [
        'numFractionalDigits' => 2,
        'symbol' => '$',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ]
]);

// This factory will create Currency objects with the same currency type.
// The rationale behind this class is that almost always we'll work with the
// same currency type.
$currencyFactory = new CurrencyFactory(
    $currencyTypeFactory->buildFromISOCode('EUR')
);

// We have many ways to construct Currency objects, depending on the data we
// have at the time.
$currency = $currencyFactory->buildFromString('10.57');
$currency = $currencyFactory->buildFromFloat(10.57);
$currency = $currencyFactory->buildFromFractionalUnits(1057);

// If we want to format a currency value, we can use a specific method, that
// will take into account the number of digits, symbol, symbol placement...
echo $currency->format();


```

## Troubleshooting

We haven't faced any interesting problem related with this library, if you are
struggling to make it work, send an email to andreu@adsmurai.com (and we'll update
this section).
