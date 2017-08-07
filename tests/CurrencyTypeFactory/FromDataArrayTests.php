<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\CurrencyTypeFactory;

use Adsmurai\Currency\Contracts\Currency;
use Adsmurai\Currency\CurrencyFactory;
use PHPUnit\Framework\TestCase;

class fromDataArrayTests extends TestCase
{
    /**
     * @covers \Adsmurai\Currency\CurrencyFactory::fromDataArray
     * @covers \Adsmurai\Currency\CurrencyFactory::validateCurrenciesData
     * @covers \Adsmurai\Currency\Errors\InvalidCurrenciesDataError
     * @expectedException \Adsmurai\Currency\Errors\InvalidCurrenciesDataError
     */
    public function test_with_empty_array()
    {
        CurrencyFactory::fromDataArray([]);
    }

    /**
     * @covers \Adsmurai\Currency\CurrencyFactory::fromDataArray
     * @covers \Adsmurai\Currency\CurrencyFactory::validateCurrenciesData
     * @covers \Adsmurai\Currency\Errors\InvalidCurrenciesDataError
     * @expectedException \Adsmurai\Currency\Errors\InvalidCurrenciesDataError
     */
    public function test_with_invalid_ISO_codes()
    {
        CurrencyFactory::fromDataArray([
            'EUR' => [
                'numFractionalDigits' => 2,
                'symbol' => '€',
                'symbolPlacement' => Currency::AFTER_PLACEMENT,
            ],
            23 => [
                'numFractionalDigits' => 2,
                'symbol' => '$',
                'symbolPlacement' => Currency::BEFORE_PLACEMENT,
            ],
        ]);
    }

    /**
     * @dataProvider missingCurrencyInfoProvider
     * @covers       \Adsmurai\Currency\CurrencyFactory::fromDataArray
     * @covers       \Adsmurai\Currency\CurrencyFactory::validateCurrenciesData
     * @expectedException \Adsmurai\Currency\Errors\InvalidCurrenciesDataError
     */
    public function test_with_missing_currency_data(array $incompleteCurrencyInfo)
    {
        CurrencyFactory::fromDataArray($incompleteCurrencyInfo);
    }

    /**
     * @dataProvider incorrectlyTypedCurrencyInfoProvider
     * @covers       \Adsmurai\Currency\CurrencyFactory::fromDataArray
     * @covers       \Adsmurai\Currency\CurrencyFactory::validateCurrenciesData
     * @expectedException \Adsmurai\Currency\Errors\InvalidCurrenciesDataError
     */
    public function test_with_incorrectly_typed_currency_data(array $invalidCurrencyInfo)
    {
        CurrencyFactory::fromDataArray($invalidCurrencyInfo);
    }

    public function missingCurrencyInfoProvider(): array
    {
        return [
            [[
                'EUR' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '€',
                    'symbolPlacement' => Currency::AFTER_PLACEMENT,
                ],
                'USD' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '$',
                ],
            ]],
            [[
                'EUR' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '€',
                    'symbolPlacement' => Currency::AFTER_PLACEMENT,
                ],
                'USD' => [
                    'numFractionalDigits' => 2,
                    'symbolPlacement' => Currency::BEFORE_PLACEMENT,
                ],
            ]],
            [[
                'EUR' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '€',
                    'symbolPlacement' => Currency::AFTER_PLACEMENT,
                ],
                'USD' => [
                    'symbol' => '$',
                    'symbolPlacement' => Currency::BEFORE_PLACEMENT,
                ],
            ]],
        ];
    }

    public function incorrectlyTypedCurrencyInfoProvider(): array
    {
        return [
            [[
                'EUR' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '€',
                    'symbolPlacement' => Currency::AFTER_PLACEMENT,
                ],
                'USD' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '$',
                    'symbolPlacement' => 'hello world',
                ],
            ]],
            [[
                'EUR' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '€',
                    'symbolPlacement' => Currency::AFTER_PLACEMENT,
                ],
                'USD' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '$',
                    'symbolPlacement' => 23,
                ],
            ]],
            [[
                'EUR' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '€',
                    'symbolPlacement' => Currency::AFTER_PLACEMENT,
                ],
                'USD' => [
                    'numFractionalDigits' => 2,
                    'symbol' => 23,
                    'symbolPlacement' => Currency::BEFORE_PLACEMENT,
                ],
            ]],
            [[
                'EUR' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '€',
                    'symbolPlacement' => Currency::AFTER_PLACEMENT,
                ],
                'USD' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '',
                    'symbolPlacement' => Currency::BEFORE_PLACEMENT,
                ],
            ]],
            [[
                'EUR' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '€',
                    'symbolPlacement' => Currency::AFTER_PLACEMENT,
                ],
                'USD' => [
                    'numFractionalDigits' => 'hello world',
                    'symbol' => '$',
                    'symbolPlacement' => Currency::BEFORE_PLACEMENT,
                ],
            ]],
        ];
    }
}
