<?php
declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Currency;
use Adsmurai\Currency\Interfaces\Currency as CurrencyInterface;
use Adsmurai\Currency\Interfaces\CurrencyType;
use Litipk\BigNumbers\Decimal;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class fromDecimalTests extends TestCase
{
    /**
     * @dataProvider validParamsProvider
     * @covers \Adsmurai\Currency\Currency::fromDecimal
     * @covers \Adsmurai\Currency\Currency::__construct
     */
    public function test_with_valid_params(Decimal $amount, CurrencyType $currencyType)
    {
        $currency = Currency::fromDecimal($amount, $currencyType);

        $this->assertInstanceOf(CurrencyInterface::class, $currency);
        $this->assertInstanceOf(Currency::class, $currency);
    }

    /**
     * @dataProvider negativeParamsProvider
     * @covers \Adsmurai\Currency\Currency::fromDecimal
     * @covers \Adsmurai\Currency\Currency::__construct
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Currency amounts must be positive
     */
    public function test_with_negative_params(Decimal $amount, CurrencyType $currencyType)
    {
        Currency::fromDecimal($amount, $currencyType);
    }

    public function validParamsProvider(): array
    {
        return [
            [Decimal::fromString('34.76'), $this->getTwoDecimalDigitsCurrencyType()],
            [Decimal::fromString('100'), $this->getTwoDecimalDigitsCurrencyType()],
            [Decimal::fromString('0.01'), $this->getTwoDecimalDigitsCurrencyType()],
            [Decimal::fromString('12345678.50'), $this->getTwoDecimalDigitsCurrencyType()]
        ];
    }

    public function negativeParamsProvider(): array
    {
        return [
            [Decimal::fromString('-34.76'), $this->getTwoDecimalDigitsCurrencyType()],
            [Decimal::fromString('-100'), $this->getTwoDecimalDigitsCurrencyType()],
            [Decimal::fromString('-0.01'), $this->getTwoDecimalDigitsCurrencyType()],
            [Decimal::fromString('-12345678.50'), $this->getTwoDecimalDigitsCurrencyType()]
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