<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Data;

use Adsmurai\Currency\Contracts\CurrencyType;

/*
 * IMPORTANT:
 * ---------------------------------------------------------------------------------------------------------------------
 *
 * The specified number of fractional digits does not match with the "legal" currencies minimum units, but with the
 * minimum units used by FACEBOOK to bill services.
 */
return [
    'EUR' => [
        'numFractionalDigits' => 2,
        'symbol' => '€',
        'symbolPlacement' => CurrencyType::AFTER_PLACEMENT,
    ],
    'USD' => [
        'numFractionalDigits' => 2,
        'symbol' => '$',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'CAD' => [
        'numFractionalDigits' => 2,
        'symbol' => '$',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'GBP' => [
        'numFractionalDigits' => 2,
        'symbol' => '£',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'PLN' => [
        'numFractionalDigits' => 2,
        'symbol' => 'zł',
        'symbolPlacement' => CurrencyType::AFTER_PLACEMENT,
    ],
    'MXN' => [
        'numFractionalDigits' => 2,
        'symbol' => '$',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'COP' => [
        'numFractionalDigits' => 0,
        'symbol' => '$',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'ARS' => [
        'numFractionalDigits' => 2,
        'symbol' => '$',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'CLP' => [
        'numFractionalDigits' => 2,
        'symbol' => '$',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'BRL' => [
        'numFractionalDigits' => 2,
        'symbol' => 'R$',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'JPY' => [
        'numFractionalDigits' => 0,
        'symbol' => '¥',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'DKK' => [
        'numFractionalDigits' => 2,
        'symbol' => 'kr',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'TRY' => [
        'numFractionalDigits' => 2,
        'symbol' => '₺',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'RUB' => [
        'numFractionalDigits' => 2,
        'symbol' => '₽',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'PYG' => [
        'numFractionalDigits' => 0,
        'symbol' => '₲',
        'symbolPlacement' => CurrencyType::AFTER_PLACEMENT,
    ],
    'PEN' => [
        'numFractionalDigits' => 2,
        'symbol' => 'S/',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'NOK' => [
        'numFractionalDigits' => 2,
        'symbol' => 'kr',
        'symbolPlacement' => CurrencyType::AFTER_PLACEMENT,
    ],
    'KRW' => [
        'numFractionalDigits' => 0,
        'symbol' => '₩',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'SGD' => [
        'numFractionalDigits' => 2,
        'symbol' => '$',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'RON' => [
        'numFractionalDigits' => 2,
        'symbol' => 'lei',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'SEK' => [
        'numFractionalDigits' => 2,
        'symbol' => 'kr',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'ZAR' => [
        'numFractionalDigits' => 2,
        'symbol' => 'R',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'HKD' => [
        'numFractionalDigits' => 2,
        'symbol' => 'HK$',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'CHF' => [
        'numFractionalDigits' => 2,
        'symbol' => 'CHF',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'NIO' => [
        'numFractionalDigits' => 2,
        'symbol' => 'C$',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'TWD' => [
        'numFractionalDigits' => 0,
        'symbol' => 'NT$',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'ISK' => [
        'numFractionalDigits' => 0,
        'symbol' => 'kr',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'NZD' => [
        'numFractionalDigits' => 2,
        'symbol' => '$',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'CZK' => [
        'numFractionalDigits' => 2,
        'symbol' => 'Kč',
        'symbolPlacement' => CurrencyType::AFTER_PLACEMENT,
    ],
    'AUD' => [
        'numFractionalDigits' => 2,
        'symbol' => '$',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'THB' => [
        'numFractionalDigits' => 2,
        'symbol' => '฿',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'BOB' => [
        'numFractionalDigits' => 2,
        'symbol' => 'R$',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'ILS' => [
        'numFractionalDigits' => 2,
        'symbol' => '₪',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'HNL' => [
        'numFractionalDigits' => 2,
        'symbol' => 'L',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'MOP' => [
        'numFractionalDigits' => 1,
        'symbol' => 'MOP$',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'UYU' => [
        'numFractionalDigits' => 2,
        'symbol' => '$U',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'CRC' => [
        'numFractionalDigits' => 0,
        'symbol' => '₡',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'QAR' => [
        'numFractionalDigits' => 2,
        'symbol' => '﷼',
        'symbolPlacement' => CurrencyType::AFTER_PLACEMENT,
    ],
    'INR' => [
        'numFractionalDigits' => 2,
        'symbol' => '₹',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'GTQ' => [
        'numFractionalDigits' => 2,
        'symbol' => 'Q',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'AED' => [
        'numFractionalDigits' => 2,
        'symbol' => 'د.إ',
        'symbolPlacement' => CurrencyType::AFTER_PLACEMENT,
    ],
    'VEF' => [
        'numFractionalDigits' => 2,
        'symbol' => 'Bs.',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'SAR' => [
        'numFractionalDigits' => 2,
        'symbol' => '﷼',
        'symbolPlacement' => CurrencyType::AFTER_PLACEMENT,
    ],
    'CNY' => [
        'numFractionalDigits' => 1,
        'symbol' => '¥',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'PHP' => [
        'numFractionalDigits' => 2,
        'symbol' => '₱',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'VND' => [
        'numFractionalDigits' => 0,
        'symbol' => '₫',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'HUF' => [
        'numFractionalDigits' => 0,
        'symbol' => 'Ft',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'IDR' => [
        'numFractionalDigits' => 0,
        'symbol' => 'Rp',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'DZD' => [
        'numFractionalDigits' => 2,
        'symbol' => 'DA',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'BDT' => [
        'numFractionalDigits' => 2,
        'symbol' => 'Tk',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'EGP' => [
        'numFractionalDigits' => 2,
        'symbol' => '£',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'KES' => [
        'numFractionalDigits' => 2,
        'symbol' => 'KSh',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'MYR' => [
        'numFractionalDigits' => 2,
        'symbol' => 'RM',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'NGN' => [
        'numFractionalDigits' => 2,
        'symbol' => '₦',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
    'PKR' => [
        'numFractionalDigits' => 2,
        'symbol' => 'Rs',
        'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
    ],
];
