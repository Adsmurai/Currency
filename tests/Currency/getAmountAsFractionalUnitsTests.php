<?php
declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Currency;
use Adsmurai\Currency\Contracts\CurrencyType;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class getAmountAsFractionalUnitsTests extends TestCase
{
    /**
     * @dataProvider stringParamsProvider
     * @covers \Adsmurai\Currency\Currency::getAmountAsFractionalUnits
     */
    public function test_from_string(string $amount, CurrencyType $currencyType, int $numFractionalUnits)
    {
        $currency = Currency::fromString($amount, $currencyType);
        $this->assertEquals($numFractionalUnits, $currency->getAmountAsFractionalUnits());
    }

    /**
     * @dataProvider floatParamsProvider
     * @covers \Adsmurai\Currency\Currency::getAmountAsFractionalUnits
     */
    public function test_from_float(float $amount, CurrencyType $currencyType, int $numFractionalUnits)
    {
        $currency = Currency::fromFloat($amount, $currencyType);
        $this->assertEquals($numFractionalUnits, $currency->getAmountAsFractionalUnits());
    }

    /**
     * @dataProvider fractionalUnitsProvider
     * @covers \Adsmurai\Currency\Currency::getAmountAsFractionalUnits
     */
    public function test_from_fractional_units(CurrencyType $currencyType, int $numFractionalUnits)
    {
        $currency = Currency::fromFractionalUnits($numFractionalUnits, $currencyType);
        $this->assertEquals($numFractionalUnits, $currency->getAmountAsFractionalUnits());
    }

    public function stringParamsProvider(): array
    {
        return [
            ['34.76', $this->getNDecimalDigitsCurrencyType(2), 3476],
            ['100', $this->getNDecimalDigitsCurrencyType(2), 10000],
            ['0.01', $this->getNDecimalDigitsCurrencyType(2), 1],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(2), 1234567850],
            ['34.76', $this->getNDecimalDigitsCurrencyType(3), 34760],
            ['100', $this->getNDecimalDigitsCurrencyType(3), 100000],
            ['0.01', $this->getNDecimalDigitsCurrencyType(3), 10],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(3), 12345678500]
        ];
    }

    public function floatParamsProvider(): array
    {
        return [
            [34.76, $this->getNDecimalDigitsCurrencyType(2), 3476],
            [100, $this->getNDecimalDigitsCurrencyType(2), 10000],
            [0.01, $this->getNDecimalDigitsCurrencyType(2), 1],
            [12345678.50, $this->getNDecimalDigitsCurrencyType(2), 1234567850],
            [34.76, $this->getNDecimalDigitsCurrencyType(3), 34760],
            [100, $this->getNDecimalDigitsCurrencyType(3), 100000],
            [0.01, $this->getNDecimalDigitsCurrencyType(3), 10],
            [12345678.50, $this->getNDecimalDigitsCurrencyType(3), 12345678500]
        ];
    }

    public function fractionalUnitsProvider(): array
    {
        return [
            [$this->getNDecimalDigitsCurrencyType(2), 3476],
            [$this->getNDecimalDigitsCurrencyType(2), 10000],
            [$this->getNDecimalDigitsCurrencyType(2), 1],
            [$this->getNDecimalDigitsCurrencyType(2), 1234567850],
            [$this->getNDecimalDigitsCurrencyType(3), 3476],
            [$this->getNDecimalDigitsCurrencyType(3), 10000],
            [$this->getNDecimalDigitsCurrencyType(3), 1],
            [$this->getNDecimalDigitsCurrencyType(3), 1234567850]
        ];
    }

    private static function getNDecimalDigitsCurrencyType(int $n = 2): CurrencyType
    {
        /** @var CurrencyType|MockInterface $currencyType */
        $currencyType = \Mockery::mock(CurrencyType::class);

        $currencyType
            ->shouldReceive('getNumFractionalDigits')
            ->andReturn($n);

        return $currencyType;
    }
}
