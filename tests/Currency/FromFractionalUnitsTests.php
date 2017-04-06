<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Currency;
use Adsmurai\Currency\Contracts\Currency as CurrencyInterface;
use Adsmurai\Currency\Contracts\CurrencyType;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class fromFractionalUnitsTests extends TestCase
{
    /**
     * @dataProvider validParamsProvider
     * @covers \Adsmurai\Currency\Currency::fromFractionalUnits
     * @covers \Adsmurai\Currency\Currency::__construct
     */
    public function test_with_valid_params(int $amount, CurrencyType $currencyType)
    {
        $currency = Currency::fromFractionalUnits($amount, $currencyType);

        $this->assertInstanceOf(CurrencyInterface::class, $currency);
        $this->assertInstanceOf(Currency::class, $currency);
    }

    /**
     * @dataProvider negativeParamsProvider
     * @covers \Adsmurai\Currency\Currency::fromFractionalUnits
     * @covers \Adsmurai\Currency\Currency::__construct
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Currency amounts must be positive
     */
    public function test_with_negative_params(int $amount, CurrencyType $currencyType)
    {
        Currency::fromFractionalUnits($amount, $currencyType);
    }

    public function validParamsProvider(): array
    {
        return [
            [3476, $this->getTwoDecimalDigitsCurrencyType()],
            [10000, $this->getTwoDecimalDigitsCurrencyType()],
            [1, $this->getTwoDecimalDigitsCurrencyType()],
            [1234567850, $this->getTwoDecimalDigitsCurrencyType()],
        ];
    }

    public function negativeParamsProvider(): array
    {
        return [
            [-3476, $this->getTwoDecimalDigitsCurrencyType()],
            [-10000, $this->getTwoDecimalDigitsCurrencyType()],
            [-1, $this->getTwoDecimalDigitsCurrencyType()],
            [-1234567850, $this->getTwoDecimalDigitsCurrencyType()],
        ];
    }

    private static function getTwoDecimalDigitsCurrencyType(): CurrencyType
    {
        /** @var CurrencyType|MockInterface $currencyType */
        $currencyType = \Mockery::mock(CurrencyType::class);

        $currencyType
            ->shouldReceive('getNumFractionalDigits')
            ->andReturn(2);

        return $currencyType;
    }
}
