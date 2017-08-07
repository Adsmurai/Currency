<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Contracts\Currency;
use Adsmurai\Currency\Money;
use PHPUnit\Framework\TestCase;

class getAmountAsFractionalUnitsTests extends TestCase
{
    /**
     * @dataProvider stringParamsProvider
     * @covers       \Adsmurai\Currency\Money::getAmountAsFractionalUnits
     */
    public function test_from_string(string $amount, Currency $currencyType, int $numFractionalUnits)
    {
        $currency = Money::fromString($amount, $currencyType);
        $this->assertEquals($numFractionalUnits, $currency->getAmountAsFractionalUnits());
    }

    /**
     * @dataProvider floatParamsProvider
     * @covers       \Adsmurai\Currency\Money::getAmountAsFractionalUnits
     */
    public function test_from_float(float $amount, Currency $currencyType, int $numFractionalUnits)
    {
        $currency = Money::fromFloat($amount, $currencyType);
        $this->assertEquals($numFractionalUnits, $currency->getAmountAsFractionalUnits());
    }

    /**
     * @dataProvider fractionalUnitsProvider
     * @covers       \Adsmurai\Currency\Money::getAmountAsFractionalUnits
     */
    public function test_from_fractional_units(Currency $currencyType, int $numFractionalUnits)
    {
        $currency = Money::fromFractionalUnits($numFractionalUnits, $currencyType);
        $this->assertEquals($numFractionalUnits, $currency->getAmountAsFractionalUnits());
    }

    public function stringParamsProvider(): array
    {
        return [
            ['34.76', CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 3476],
            ['100', CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 10000],
            ['0.01', CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 1],
            ['12345678.50', CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 1234567850],
            ['34.76', CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 34760],
            ['100', CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 100000],
            ['0.01', CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 10],
            ['12345678.50', CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 12345678500],
        ];
    }

    public function floatParamsProvider(): array
    {
        return [
            [34.76, CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 3476],
            [100, CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 10000],
            [0.01, CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 1],
            [12345678.50, CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 1234567850],
            [34.76, CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 34760],
            [100, CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 100000],
            [0.01, CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 10],
            [12345678.50, CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 12345678500],
        ];
    }

    public function fractionalUnitsProvider(): array
    {
        return [
            [CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 3476],
            [CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 10000],
            [CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 1],
            [CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 1234567850],
            [CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 3476],
            [CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 10000],
            [CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 1],
            [CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 1234567850],
        ];
    }
}
