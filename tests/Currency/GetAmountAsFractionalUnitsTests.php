<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Contracts\Currency;
use Adsmurai\Currency\Money;
use PHPUnit\Framework\TestCase;

class GetAmountAsFractionalUnitsTests extends TestCase
{
    /**
     * @dataProvider stringParamsProvider
     * @covers       \Adsmurai\Currency\Money::getAmountAsFractionalUnits
     */
    public function test_from_string(string $amount, Currency $currencyType, int $numFractionalUnits)
    {
        $currency = Money::fromString($amount, $currencyType);
        $this->assertSame($numFractionalUnits, $currency->getAmountAsFractionalUnits());
    }

    /**
     * @dataProvider floatParamsProvider
     * @covers       \Adsmurai\Currency\Money::getAmountAsFractionalUnits
     */
    public function test_from_float(float $amount, Currency $currencyType, int $numFractionalUnits)
    {
        $currency = Money::fromFloat($amount, $currencyType);
        $this->assertSame($numFractionalUnits, $currency->getAmountAsFractionalUnits());
    }

    /**
     * @dataProvider fractionalUnitsProvider
     * @covers       \Adsmurai\Currency\Money::getAmountAsFractionalUnits
     */
    public function test_from_fractional_units(Currency $currencyType, int $numFractionalUnits)
    {
        $currency = Money::fromFractionalUnits($numFractionalUnits, $currencyType);
        $this->assertSame($numFractionalUnits, $currency->getAmountAsFractionalUnits());
    }

    public static function stringParamsProvider(): \Iterator
    {
        yield ['34.76', CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 3476];
        yield ['100', CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 10000];
        yield ['0.01', CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 1];
        yield ['12345678.50', CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 1234567850];
        yield ['34.76', CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 34760];
        yield ['100', CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 100000];
        yield ['0.01', CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 10];
        yield ['12345678.50', CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 12345678500];
    }

    public static function floatParamsProvider(): \Iterator
    {
        yield [34.76, CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 3476];
        yield [100, CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 10000];
        yield [0.01, CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 1];
        yield [12345678.50, CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 1234567850];
        yield [34.76, CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 34760];
        yield [100, CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 100000];
        yield [0.01, CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 10];
        yield [12345678.50, CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 12345678500];
    }

    public static function fractionalUnitsProvider(): \Iterator
    {
        yield [CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 3476];
        yield [CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 10000];
        yield [CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 1];
        yield [CurrencyTypeMocks::getNDecimalDigitsCurrencyType(2), 1234567850];
        yield [CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 3476];
        yield [CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 10000];
        yield [CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 1];
        yield [CurrencyTypeMocks::getNDecimalDigitsCurrencyType(3), 1234567850];
    }
}
