<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Contracts\Money as CurrencyInterface;
use Adsmurai\Currency\Contracts\Currency;
use Adsmurai\Currency\Money;
use PHPUnit\Framework\TestCase;

class FromFractionalUnitsTests extends TestCase
{
    /**
     * @dataProvider validParamsProvider
     * @covers       \Adsmurai\Currency\Money::fromFractionalUnits
     * @covers       \Adsmurai\Currency\Money::__construct
     */
    public function test_with_valid_params(int $amount, Currency $currencyType): void
    {
        $currency = Money::fromFractionalUnits($amount, $currencyType);

        $this->assertInstanceOf(CurrencyInterface::class, $currency);
        $this->assertInstanceOf(Money::class, $currency);
    }

    public static function validParamsProvider(): \Iterator
    {
        yield [3476, CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()];
        yield [10000, CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()];
        yield [1, CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()];
        yield [1234567850, CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()];
        yield [-3476, CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()];
        yield [-10000, CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()];
        yield [-1, CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()];
        yield [-1234567850, CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType()];
    }
}
