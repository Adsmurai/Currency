<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Contracts\Money as CurrencyInterface;
use Adsmurai\Currency\Contracts\Currency;
use Adsmurai\Currency\Money;
use Litipk\BigNumbers\Decimal;
use PHPUnit\Framework\TestCase;

class fromDecimalTests extends TestCase
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

    public function validParamsProvider(): array
    {
        return [
            [Decimal::fromString('34.76'), CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()],
            [Decimal::fromString('100'), CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()],
            [Decimal::fromString('0.01'), CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()],
            [Decimal::fromString('12345678.50'), CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()],
            [Decimal::fromString('-34.76'), CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()],
            [Decimal::fromString('-100'), CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()],
            [Decimal::fromString('-0.01'), CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()],
            [Decimal::fromString('-12345678.50'), CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()],
        ];
    }
}
