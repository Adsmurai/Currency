<?php

// @codeCoverageIgnoreStart
declare(strict_types=1);

namespace Adsmurai\Currency\Data;

use Adsmurai\Currency\Contracts\Currency;

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
        'symbolPlacement' => Currency::AFTER_PLACEMENT,
    ],
    'USD' => [
        'numFractionalDigits' => 2,
        'symbol' => '$',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'CAD' => [
        'numFractionalDigits' => 2,
        'symbol' => '$',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'GBP' => [
        'numFractionalDigits' => 2,
        'symbol' => '£',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'PLN' => [
        'numFractionalDigits' => 2,
        'symbol' => 'zł',
        'symbolPlacement' => Currency::AFTER_PLACEMENT,
    ],
    'MXN' => [
        'numFractionalDigits' => 2,
        'symbol' => '$',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'COP' => [
        'numFractionalDigits' => 2,
        'symbol' => '$',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'ARS' => [
        'numFractionalDigits' => 2,
        'symbol' => '$',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'CLP' => [
        'numFractionalDigits' => 2,
        'symbol' => '$',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'BRL' => [
        'numFractionalDigits' => 2,
        'symbol' => 'R$',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'JPY' => [
        'numFractionalDigits' => 0,
        'symbol' => '¥',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'DKK' => [
        'numFractionalDigits' => 2,
        'symbol' => 'kr',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'TRY' => [
        'numFractionalDigits' => 2,
        'symbol' => '₺',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'RUB' => [
        'numFractionalDigits' => 2,
        'symbol' => '₽',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'PYG' => [
        'numFractionalDigits' => 0,
        'symbol' => '₲',
        'symbolPlacement' => Currency::AFTER_PLACEMENT,
    ],
    'PEN' => [
        'numFractionalDigits' => 2,
        'symbol' => 'S/',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'NOK' => [
        'numFractionalDigits' => 2,
        'symbol' => 'kr',
        'symbolPlacement' => Currency::AFTER_PLACEMENT,
    ],
    'KRW' => [
        'numFractionalDigits' => 0,
        'symbol' => '₩',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'SGD' => [
        'numFractionalDigits' => 2,
        'symbol' => '$',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'RON' => [
        'numFractionalDigits' => 2,
        'symbol' => 'lei',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'SEK' => [
        'numFractionalDigits' => 2,
        'symbol' => 'kr',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'ZAR' => [
        'numFractionalDigits' => 2,
        'symbol' => 'R',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'HKD' => [
        'numFractionalDigits' => 2,
        'symbol' => 'HK$',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'CHF' => [
        'numFractionalDigits' => 2,
        'symbol' => 'CHF',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'NIO' => [
        'numFractionalDigits' => 2,
        'symbol' => 'C$',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'TWD' => [
        'numFractionalDigits' => 2,
        'symbol' => 'NT$',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'ISK' => [
        'numFractionalDigits' => 0,
        'symbol' => 'kr',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'NZD' => [
        'numFractionalDigits' => 2,
        'symbol' => '$',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'CZK' => [
        'numFractionalDigits' => 2,
        'symbol' => 'Kč',
        'symbolPlacement' => Currency::AFTER_PLACEMENT,
    ],
    'AUD' => [
        'numFractionalDigits' => 2,
        'symbol' => '$',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'THB' => [
        'numFractionalDigits' => 2,
        'symbol' => '฿',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'BOB' => [
        'numFractionalDigits' => 2,
        'symbol' => 'R$',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'ILS' => [
        'numFractionalDigits' => 2,
        'symbol' => '₪',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'HNL' => [
        'numFractionalDigits' => 2,
        'symbol' => 'L',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'MOP' => [
        'numFractionalDigits' => 1,
        'symbol' => 'MOP$',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'UYU' => [
        'numFractionalDigits' => 2,
        'symbol' => '$U',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'CRC' => [
        'numFractionalDigits' => 2,
        'symbol' => '₡',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'INR' => [
        'numFractionalDigits' => 2,
        'symbol' => '₹',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'GTQ' => [
        'numFractionalDigits' => 2,
        'symbol' => 'Q',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'AED' => [
        'numFractionalDigits' => 2,
        'symbol' => 'د.إ',
        'symbolPlacement' => Currency::AFTER_PLACEMENT,
    ],
    'VEF' => [
        'numFractionalDigits' => 2,
        'symbol' => 'Bs.',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'CNY' => [
        'numFractionalDigits' => 1,
        'symbol' => '¥',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'PHP' => [
        'numFractionalDigits' => 2,
        'symbol' => '₱',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'VND' => [
        'numFractionalDigits' => 0,
        'symbol' => '₫',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'HUF' => [
        'numFractionalDigits' => 2,
        'symbol' => 'Ft',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'IDR' => [
        'numFractionalDigits' => 2,
        'symbol' => 'Rp',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'DZD' => [
        'numFractionalDigits' => 2,
        'symbol' => 'DA',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'BDT' => [
        'numFractionalDigits' => 2,
        'symbol' => 'Tk',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'EGP' => [
        'numFractionalDigits' => 2,
        'symbol' => '£',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'KES' => [
        'numFractionalDigits' => 2,
        'symbol' => 'KSh',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'MYR' => [
        'numFractionalDigits' => 2,
        'symbol' => 'RM',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'NGN' => [
        'numFractionalDigits' => 2,
        'symbol' => '₦',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'PKR' => [
        'numFractionalDigits' => 2,
        'symbol' => 'Rs',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'LKR' => [
        'numFractionalDigits' => 2,
        'symbol' => 'Rs',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'BHD' => [
        'numFractionalDigits' => 3,
        'symbol' => 'BD',
        'symbolPlacement' => Currency::AFTER_PLACEMENT,
    ],
    'KWD' => [
        'numFractionalDigits' => 3,
        'symbol' => 'د.ك',
        'symbolPlacement' => Currency::AFTER_PLACEMENT,
    ],
    'LBP' => [
        'numFractionalDigits' => 2,
        'symbol' => 'ل.ل',
        'symbolPlacement' => Currency::AFTER_PLACEMENT,
    ],
    'JOD' => [
        'numFractionalDigits' => 3,
        'symbol' => 'JD',
        'symbolPlacement' => Currency::AFTER_PLACEMENT,
    ],
    'MAD' => [
        'numFractionalDigits' => 2,
        'symbol' => 'درهم',
        'symbolPlacement' => Currency::AFTER_PLACEMENT,
    ],
    'QAR' => [
        'numFractionalDigits' => 2,
        'symbol' => 'ر.ق',
        'symbolPlacement' => Currency::BEFORE_PLACEMENT,
    ],
    'SAR' => [
        'numFractionalDigits' => 2,
        'symbol' => 'ر.س',
        'symbolPlacement' => Currency::AFTER_PLACEMENT,
    ],
    'RSD' => [
        'numFractionalDigits' => 2,
        'symbol' => 'дин',
        'symbolPlacement' => Currency::AFTER_PLACEMENT,
    ],
    'HRK' => [
        'numFractionalDigits' => 2,
        'symbol' => 'kn',
        'symbolPlacement' => Currency::AFTER_PLACEMENT,
    ],
    'OMR' => [
        'numFractionalDigits' => 3,
        'symbol' => 'ر.ع.',
        'symbolPlacement' => Currency::AFTER_PLACEMENT,
    ],
];
// @codeCoverageIgnoreEnd
