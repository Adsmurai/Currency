<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Contracts\Currency as CurrencyInterface;
use Adsmurai\Currency\Contracts\CurrencyType;
use Adsmurai\Currency\Currency;
use PHPUnit\Framework\TestCase;

class fromFloatTests extends TestCase
{
    /**
     * @dataProvider validParamsProvider
     * @covers       \Adsmurai\Currency\Currency::fromFloat
     * @covers       \Adsmurai\Currency\Currency::__construct
     */
    public function test_with_valid_params(float $amount, CurrencyType $currencyType)
    {
        $currency = Currency::fromFloat($amount, $currencyType);

        $this->assertInstanceOf(CurrencyInterface::class, $currency);
        $this->assertInstanceOf(Currency::class, $currency);
    }

    /**
     * @dataProvider negativeParamsProvider
     * @covers       \Adsmurai\Currency\Currency::fromFloat
     * @covers       \Adsmurai\Currency\Currency::__construct
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Currency amounts must be positive
     */
    public function test_with_negative_amounts(float $amount, CurrencyType $currencyType)
    {
        Currency::fromFloat($amount, $currencyType);
    }

    /**
     * @dataProvider infiniteParamsProvider
     * @covers       \Adsmurai\Currency\Currency::fromFloat
     * @covers       \Adsmurai\Currency\Currency::__construct
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Currency amounts must be finite
     */
    public function test_with_infinite_amounts(float $amount, CurrencyType $currencyType)
    {
        Currency::fromFloat($amount, $currencyType);
    }

    /**
     * @covers \Adsmurai\Currency\Currency::fromFloat
     * @covers \Adsmurai\Currency\Currency::__construct
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Currency amounts must be numbers
     */
    public function test_with_nan_amount()
    {
        Currency::fromFloat(\NAN, CurrencyTypeMocks::getCurrencyTypeDummyMock());
    }

    public function validParamsProvider(): array
    {
        return [
            [34.76, CurrencyTypeMocks::getCurrencyTypeDummyMock()],
            [100, CurrencyTypeMocks::getCurrencyTypeDummyMock()],
            [0.01, CurrencyTypeMocks::getCurrencyTypeDummyMock()],
            [12345678.50, CurrencyTypeMocks::getCurrencyTypeDummyMock()],
        ];
    }

    public function negativeParamsProvider(): array
    {
        return [
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
