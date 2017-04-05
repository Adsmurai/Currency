<?php

namespace Adsmurai\Currency\Tests;

use Adsmurai\Currency\CurrencyTypeFactory;
use Adsmurai\Currency\Errors\InvalidCurrencyTypesDataError;
use Adsmurai\Currency\Interfaces\CurrencyType;
use PHPUnit\Framework\TestCase;

class CurrencyTypeFactoryTests extends TestCase
{
    /**
     * @dataProvider commonCurrenciesProvider
     * @covers \Adsmurai\Currency\CurrencyTypeFactory
     */
    public function test_getCurrencyType_with_common_currencies(string $ISOCode)
    {
        /** @var array $currencyData */
        $currencyData = $this->getCurrenciesData()[$ISOCode];
        $currencyTypeFactory = CurrencyTypeFactory::fromDataPath();

        $currencyType = $currencyTypeFactory->getCurrencyType($ISOCode);

        $this->assertInstanceOf(CurrencyType::class, $currencyType);
        $this->assertEquals($ISOCode, $currencyType->getISOCode());
        $this->assertEquals($currencyData['symbol'], $currencyType->getSymbol());
        $this->assertEquals($currencyData['symbolPlacement'], $currencyType->getSymbolPlacement());
        $this->assertEquals($currencyData['numFractionalDigits'], $currencyType->getNumFractionalDigits());
    }

    /**
     * @covers \Adsmurai\Currency\CurrencyTypeFactory::fromDataArray
     * @covers \Adsmurai\Currency\CurrencyTypeFactory::validateCurrenciesData
     * @expectedException \Adsmurai\Currency\Errors\InvalidCurrencyTypesDataError
     */
    public function test_fromDataArray_with_empty_array()
    {
        $currencyTypeFactory = CurrencyTypeFactory::fromDataArray([]);
    }

    /**
     * @covers \Adsmurai\Currency\CurrencyTypeFactory::fromDataArray
     * @covers \Adsmurai\Currency\CurrencyTypeFactory::validateCurrenciesData
     * @expectedException \Adsmurai\Currency\Errors\InvalidCurrencyTypesDataError
     */
    public function test_fromDataArray_with_invalid_ISO_codes()
    {
        $currencyTypeFactory = CurrencyTypeFactory::fromDataArray([
            'EUR' => [
                'numFractionalDigits' => 2,
                'symbol' => '€',
                'symbolPlacement' => CurrencyType::AFTER_PLACEMENT
            ],
            23 => [
                'numFractionalDigits' => 2,
                'symbol' => '$',
                'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT
            ],
        ]);
    }

    /**
     * @dataProvider missingCurrencyInfoProvider
     * @covers \Adsmurai\Currency\CurrencyTypeFactory::fromDataArray
     * @covers \Adsmurai\Currency\CurrencyTypeFactory::validateCurrenciesData
     * @expectedException \Adsmurai\Currency\Errors\InvalidCurrencyTypesDataError
     */
    public function test_fromDataArray_with_missing_currency_data(array $incompleteCurrencyInfo)
    {
        $currencyTypeFactory = CurrencyTypeFactory::fromDataArray($incompleteCurrencyInfo);
    }

    /**
     * @dataProvider incorrectlyTypedCurrencyInfoProvider
     * @covers \Adsmurai\Currency\CurrencyTypeFactory::fromDataArray
     * @covers \Adsmurai\Currency\CurrencyTypeFactory::validateCurrenciesData
     * @expectedException \Adsmurai\Currency\Errors\InvalidCurrencyTypesDataError
     */
    public function test_fromDataArray_with_incorrectly_typed_currency_data(array $invalidCurrencyInfo)
    {
        $currencyTypeFactory = CurrencyTypeFactory::fromDataArray($invalidCurrencyInfo);
    }

    public function commonCurrenciesProvider(): array
    {
        return \array_map(
            function (string $ISOCode) {
                return [$ISOCode];
            },
            \array_keys($this->getCurrenciesData())
        );
    }

    public function missingCurrencyInfoProvider(): array
    {
        return [
            [[
                'EUR' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '€',
                    'symbolPlacement' => CurrencyType::AFTER_PLACEMENT
                ],
                'USD' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '$'
                ],
            ]],
            [[
                'EUR' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '€',
                    'symbolPlacement' => CurrencyType::AFTER_PLACEMENT
                ],
                'USD' => [
                    'numFractionalDigits' => 2,
                    'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT
                ],
            ]],
            [[
                'EUR' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '€',
                    'symbolPlacement' => CurrencyType::AFTER_PLACEMENT
                ],
                'USD' => [
                    'symbol' => '$',
                    'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT
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
                    'symbolPlacement' => CurrencyType::AFTER_PLACEMENT
                ],
                'USD' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '$',
                    'symbolPlacement' => 'hello world'
                ],
            ]],
            [[
                'EUR' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '€',
                    'symbolPlacement' => CurrencyType::AFTER_PLACEMENT
                ],
                'USD' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '$',
                    'symbolPlacement' => 23
                ],
            ]],
            [[
                'EUR' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '€',
                    'symbolPlacement' => CurrencyType::AFTER_PLACEMENT
                ],
                'USD' => [
                    'numFractionalDigits' => 2,
                    'symbol' => 23,
                    'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT
                ],
            ]],
            [[
                'EUR' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '€',
                    'symbolPlacement' => CurrencyType::AFTER_PLACEMENT
                ],
                'USD' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '',
                    'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT
                ],
            ]],
            [[
                'EUR' => [
                    'numFractionalDigits' => 2,
                    'symbol' => '€',
                    'symbolPlacement' => CurrencyType::AFTER_PLACEMENT
                ],
                'USD' => [
                    'numFractionalDigits' => 'hello world',
                    'symbol' => '$',
                    'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT
                ],
            ]],
        ];
    }

    private function getCurrenciesData(): array
    {
        /** @var array $currenciesData */
        $currenciesData = include __DIR__ . '/../src/Data/CurrencyTypes.php';

        return $currenciesData;
    }
}
