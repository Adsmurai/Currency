<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Contracts\Money as CurrencyInterface;
use Adsmurai\Currency\Contracts\Currency;
use Adsmurai\Currency\Money;
use PHPUnit\Framework\TestCase;

class fromFloatTests extends TestCase
{
    /**
     * @dataProvider validParamsProvider
     * @covers       \Adsmurai\Currency\Money::fromFloat
     * @covers       \Adsmurai\Currency\Money::__construct
     */
    public function test_with_valid_params(float $amount, Currency $currencyType)
    {
        $currency = Money::fromFloat($amount, $currencyType);

        $this->assertInstanceOf(CurrencyInterface::class, $currency);
        $this->assertInstanceOf(Money::class, $currency);
    }

    /**
     * @dataProvider infiniteParamsProvider
     * @covers       \Adsmurai\Currency\Money::fromFloat
     * @covers       \Adsmurai\Currency\Money::__construct
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Currency amounts must be finite
     */
    public function test_with_infinite_amounts(float $amount, Currency $currencyType)
    {
        Money::fromFloat($amount, $currencyType);
    }

    /**
     * @covers \Adsmurai\Currency\Money::fromFloat
     * @covers \Adsmurai\Currency\Money::__construct
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Currency amounts must be numbers
     */
    public function test_with_nan_amount()
    {
        Money::fromFloat(\NAN, CurrencyTypeMocks::getCurrencyTypeDummyMock());
    }

    public function validParamsProvider(): array
    {
        return [
            [34.76, CurrencyTypeMocks::getCurrencyTypeDummyMock()],
            [100, CurrencyTypeMocks::getCurrencyTypeDummyMock()],
            [0.01, CurrencyTypeMocks::getCurrencyTypeDummyMock()],
            [12345678.50, CurrencyTypeMocks::getCurrencyTypeDummyMock()],
            [-34.76, CurrencyTypeMocks::getCurrencyTypeDummyMock()],
            [-100, CurrencyTypeMocks::getCurrencyTypeDummyMock()],
            [-0.01, CurrencyTypeMocks::getCurrencyTypeDummyMock()],
            [-12345678.50, CurrencyTypeMocks::getCurrencyTypeDummyMock()],
        ];
    }

    public function infiniteParamsProvider(): array
    {
        return [
            [-INF, CurrencyTypeMocks::getCurrencyTypeDummyMock()],
            [+INF, CurrencyTypeMocks::getCurrencyTypeDummyMock()],
        ];
    }
}
