<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Contracts\Money as CurrencyInterface;
use Adsmurai\Currency\Contracts\Currency;
use Adsmurai\Currency\Money;
use Litipk\BigNumbers\Decimal;
use PHPUnit\Framework\TestCase;

class FromDecimalTests extends TestCase
{
    /**
     * @dataProvider validParamsProvider
     * @covers       \Adsmurai\Currency\Money::fromDecimal
     * @covers       \Adsmurai\Currency\Money::__construct
     */
    public function test_with_valid_params(Decimal $amount, Currency $currencyType)
    {
        $currency = Money::fromDecimal($amount, $currencyType);

        $this->assertInstanceOf(CurrencyInterface::class, $currency);
        $this->assertInstanceOf(Money::class, $currency);
    }

    public static function validParamsProvider(): \Iterator
    {
        yield [Decimal::fromString('34.76'), CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()];
        yield [Decimal::fromString('100'), CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()];
        yield [Decimal::fromString('0.01'), CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()];
        yield [Decimal::fromString('12345678.50'), CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()];
        yield [Decimal::fromString('-34.76'), CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()];
        yield [Decimal::fromString('-100'), CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()];
        yield [Decimal::fromString('-0.01'), CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()];
        yield [Decimal::fromString('-12345678.50'), CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()];
    }
}
