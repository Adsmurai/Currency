<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Contracts\Money as CurrencyInterface;
use Adsmurai\Currency\Contracts\Currency;
use Adsmurai\Currency\Money;
use PHPUnit\Framework\TestCase;

class FromFloatTests extends TestCase
{
    /**
     * @dataProvider validParamsProvider
     * @covers       \Adsmurai\Currency\Money::fromFloat
     * @covers       \Adsmurai\Currency\Money::__construct
     */
    public function test_with_valid_params(float $amount, Currency $currencyType): void
    {
        $currency = Money::fromFloat($amount, $currencyType);

        $this->assertInstanceOf(CurrencyInterface::class, $currency);
        $this->assertInstanceOf(Money::class, $currency);
    }

    /**
     * @dataProvider infiniteParamsProvider
     * @covers       \Adsmurai\Currency\Money::fromFloat
     * @covers       \Adsmurai\Currency\Money::__construct
     */
    public function test_with_infinite_amounts(float $amount, Currency $currencyType): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Currency amounts must be finite');

        Money::fromFloat($amount, $currencyType);
    }

    /**
     * @covers \Adsmurai\Currency\Money::fromFloat
     * @covers \Adsmurai\Currency\Money::__construct
     */
    public function test_with_nan_amount(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Currency amounts must be numbers');

        Money::fromFloat(\NAN, CurrencyTypeMocks::getCurrencyTypeDummyMock());
    }

    public static function validParamsProvider(): \Iterator
    {
        yield [34.76, CurrencyTypeMocks::getCurrencyTypeDummyMock()];
        yield [100, CurrencyTypeMocks::getCurrencyTypeDummyMock()];
        yield [0.01, CurrencyTypeMocks::getCurrencyTypeDummyMock()];
        yield [12345678.50, CurrencyTypeMocks::getCurrencyTypeDummyMock()];
        yield [-34.76, CurrencyTypeMocks::getCurrencyTypeDummyMock()];
        yield [-100, CurrencyTypeMocks::getCurrencyTypeDummyMock()];
        yield [-0.01, CurrencyTypeMocks::getCurrencyTypeDummyMock()];
        yield [-12345678.50, CurrencyTypeMocks::getCurrencyTypeDummyMock()];
    }

    public static function infiniteParamsProvider(): \Iterator
    {
        yield [-INF, CurrencyTypeMocks::getCurrencyTypeDummyMock()];
        yield [+INF, CurrencyTypeMocks::getCurrencyTypeDummyMock()];
    }
}
