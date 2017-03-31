<?php

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Currency;
use Adsmurai\Currency\Interfaces\Currency as CurrencyInterface;
use Adsmurai\Currency\Interfaces\CurrencyType;
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

    public function validParamsProvider(): array
    {
        return [
            [3476, $this->getTwoDecimalDigitsCurrencyType()],
            [10000, $this->getTwoDecimalDigitsCurrencyType()],
            [1, $this->getTwoDecimalDigitsCurrencyType()],
            [1234567850, $this->getTwoDecimalDigitsCurrencyType()]
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
