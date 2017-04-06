<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\CurrenCyTypeFactory;

use Adsmurai\Currency\CurrencyTypeFactory;
use Adsmurai\Currency\Contracts\CurrencyType;
use PHPUnit\Framework\TestCase;

class fromDataArrayTests extends TestCase
{
    /**
     * @covers \Adsmurai\Currency\CurrencyTypeFactory::fromDataArray
     * @covers \Adsmurai\Currency\CurrencyTypeFactory::validateCurrenciesData
     * @expectedException \Adsmurai\Currency\Errors\InvalidCurrencyTypesDataError
     */
    public function test_with_empty_array()
    {
        CurrencyTypeFactory::fromDataArray([]);
    }

    /**
     * @covers \Adsmurai\Currency\CurrencyTypeFactory::fromDataArray
     * @covers \Adsmurai\Currency\CurrencyTypeFactory::validateCurrenciesData
     * @expectedException \Adsmurai\Currency\Errors\InvalidCurrencyTypesDataError
     */
    public function test_with_invalid_ISO_codes()
    {
        CurrencyTypeFactory::fromDataArray([
            'EUR' => [
                'numFractionalDigits' => 2,
                'symbol' => '€',
                'symbolPlacement' => CurrencyType::AFTER_PLACEMENT,
            ],
            23 => [
                'numFractionalDigits' => 2,
                'symbol' => '$',
                'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
            ],
        ]);
    }

    /**
     * @dataProvider missingCurrencyInfoProvider
     * @covers \Adsmurai\Currency\CurrencyTypeFactory::fromDataArray
     * @covers \Adsmurai\Currency\CurrencyTypeFactory::validateCurrenciesData
     * @expectedException \Adsmurai\Currency\Errors\InvalidCurrencyTypesDataError
     */
    public function test_with_missing_currency_data(array $incompleteCurrencyInfo)
    {
        CurrencyTypeFactory::fromDataArray($incompleteCurrencyInfo);
    }

    /**
     * @dataProvider incorrectlyTypedCurrencyInfoProvider
     * @covers \Adsmurai\Currency\CurrencyTypeFactory::fromDataArray
     * @covers \Adsmurai\Currency\CurrencyTypeFactory::validateCurrenciesData
     * @expectedException \Adsmurai\Currency\Errors\InvalidCurrencyTypesDataError
     */
    public function test_with_incorrectly_typed_currency_data(array $invalidCurrencyInfo)
    {
        CurrencyTypeFactory::fromDataArray($invalidCurrencyInfo);
    }

    public function missingCurrencyInfoProvider(): array
    {
        return [
            [[
                'EUR' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '€',
                    'symbolPlacement' => CurrencyType::AFTER_PLACEMENT,
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
                    'symbolPlacement' => CurrencyType::AFTER_PLACEMENT,
                ],
                'USD' => [
                    'numFractionalDigits' => 2,
                    'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
                ],
            ]],
            [[
                'EUR' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '€',
                    'symbolPlacement' => CurrencyType::AFTER_PLACEMENT,
                ],
                'USD' => [
                    'symbol' => '$',
                    'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
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
                    'symbolPlacement' => CurrencyType::AFTER_PLACEMENT,
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
                    'symbolPlacement' => CurrencyType::AFTER_PLACEMENT,
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
                    'symbolPlacement' => CurrencyType::AFTER_PLACEMENT,
                ],
                'USD' => [
                    'numFractionalDigits' => 2,
                    'symbol' => 23,
                    'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
                ],
            ]],
            [[
                'EUR' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '€',
                    'symbolPlacement' => CurrencyType::AFTER_PLACEMENT,
                ],
                'USD' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '',
                    'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
                ],
            ]],
            [[
                'EUR' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '€',
                    'symbolPlacement' => CurrencyType::AFTER_PLACEMENT,
                ],
                'USD' => [
                    'numFractionalDigits' => 'hello world',
                    'symbol' => '$',
                    'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
                ],
            ]],
        ];
    }
}
