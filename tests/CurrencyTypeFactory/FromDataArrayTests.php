<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\CurrencyTypeFactory;

use Adsmurai\Currency\Contracts\Currency;
use Adsmurai\Currency\CurrencyFactory;
use PHPUnit\Framework\TestCase;

class FromDataArrayTests extends TestCase
{
    /**
     * @covers \Adsmurai\Currency\CurrencyFactory::fromDataArray
     * @covers \Adsmurai\Currency\CurrencyFactory::validateCurrenciesData
     * @covers \Adsmurai\Currency\Errors\InvalidCurrenciesDataError
     */
    public function test_with_empty_array(): void
    {
        $this->expectException(\Adsmurai\Currency\Errors\InvalidCurrenciesDataError::class);

        CurrencyFactory::fromDataArray([]);
    }

    /**
     * @covers \Adsmurai\Currency\CurrencyFactory::fromDataArray
     * @covers \Adsmurai\Currency\CurrencyFactory::validateCurrenciesData
     * @covers \Adsmurai\Currency\Errors\InvalidCurrenciesDataError
     */
    public function test_with_invalid_ISO_codes(): void
    {
        $this->expectException(\Adsmurai\Currency\Errors\InvalidCurrenciesDataError::class);

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
     */
    public function test_with_missing_currency_data(array $incompleteCurrencyInfo): void
    {
        $this->expectException(\Adsmurai\Currency\Errors\InvalidCurrenciesDataError::class);

        CurrencyFactory::fromDataArray($incompleteCurrencyInfo);
    }

    /**
     * @dataProvider incorrectlyTypedCurrencyInfoProvider
     * @covers       \Adsmurai\Currency\CurrencyFactory::fromDataArray
     * @covers       \Adsmurai\Currency\CurrencyFactory::validateCurrenciesData
     */
    public function test_with_incorrectly_typed_currency_data(array $invalidCurrencyInfo): void
    {
        $this->expectException(\Adsmurai\Currency\Errors\InvalidCurrenciesDataError::class);

        CurrencyFactory::fromDataArray($invalidCurrencyInfo);
    }

    public static function missingCurrencyInfoProvider(): \Iterator
    {
        yield [[
            'EUR' => [
                'numFractionalDigits' => 2,
                'symbol' => '€',
                'symbolPlacement' => Currency::AFTER_PLACEMENT,
            ],
            'USD' => [
                'numFractionalDigits' => 2,
                'symbol' => '$',
            ],
        ]];
        yield [[
            'EUR' => [
                'numFractionalDigits' => 2,
                'symbol' => '€',
                'symbolPlacement' => Currency::AFTER_PLACEMENT,
            ],
            'USD' => [
                'numFractionalDigits' => 2,
                'symbolPlacement' => Currency::BEFORE_PLACEMENT,
            ],
        ]];
        yield [[
            'EUR' => [
                'numFractionalDigits' => 2,
                'symbol' => '€',
                'symbolPlacement' => Currency::AFTER_PLACEMENT,
            ],
            'USD' => [
                'symbol' => '$',
                'symbolPlacement' => Currency::BEFORE_PLACEMENT,
            ],
        ]];
    }

    public static function incorrectlyTypedCurrencyInfoProvider(): \Iterator
    {
        yield [[
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
        ]];
        yield [[
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
        ]];
        yield [[
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
        ]];
        yield [[
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
        ]];
        yield [[
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
        ]];
    }
}
