<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Contracts\Money as CurrencyInterface;
use Adsmurai\Currency\Contracts\Currency;
use Adsmurai\Currency\Money;
use PHPUnit\Framework\TestCase;

class fromFractionalUnitsTests extends TestCase
{
    /**
     * @dataProvider validParamsProvider
     * @covers       \Adsmurai\Currency\Money::fromFractionalUnits
     * @covers       \Adsmurai\Currency\Money::__construct
     */
    public function test_with_valid_params(int $amount, Currency $currencyType)
    {
        $currency = Money::fromFractionalUnits($amount, $currencyType);

        $this->assertInstanceOf(CurrencyInterface::class, $currency);
        $this->assertInstanceOf(Money::class, $currency);
    }

    /**
     * @dataProvider negativeParamsProvider
     * @covers       \Adsmurai\Currency\Money::fromFractionalUnits
     * @covers       \Adsmurai\Currency\Money::__construct
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Currency amounts must be positive
     */
    public function test_with_negative_params(int $amount, Currency $currencyType)
    {
        Money::fromFractionalUnits($amount, $currencyType);
    }

    public function validParamsProvider(): array
    {
        return [
            [3476, CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()],
            [10000, CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()],
            [1, CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()],
            [1234567850, CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()],
        ];
    }

    public function negativeParamsProvider(): array
    {
        return [
            [-3476, CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()],
            [-10000, CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()],
            [-1, CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()],
            [-1234567850, CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()],
        ];
    }
}
