<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Currency;
use Adsmurai\Currency\Contracts\Currency as CurrencyInterface;
use Adsmurai\Currency\Contracts\CurrencyType;
use Litipk\BigNumbers\Decimal;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class equalsTests extends TestCase
{
    /**
     * @dataProvider equalCurrenciesProvider
     */
    public function test_equality(CurrencyInterface $c1, CurrencyInterface $c2)
    {
        $this->assertTrue($c1->equals($c2));
        $this->assertTrue($c2->equals($c1));
    }

    /**
     * @dataProvider unequalCurrenciesProvider
     */
    public function test_inequality(CurrencyInterface $c1, CurrencyInterface $c2)
    {
        $this->assertFalse($c1->equals($c2));
        $this->assertFalse($c2->equals($c1));
    }

    public function equalCurrenciesProvider(): array
    {
        return [
            [
                Currency::fromString('34.75', $this->getTwoDecimalDigitsCurrencyType()),
                Currency::fromString('34.75', $this->getTwoDecimalDigitsCurrencyType()),
            ],
            [
                Currency::fromString('34.75', $this->getTwoDecimalDigitsCurrencyType()),
                Currency::fromFloat(34.75, $this->getTwoDecimalDigitsCurrencyType()),
            ],
            [
                Currency::fromString('34.75', $this->getTwoDecimalDigitsCurrencyType()),
                Currency::fromFractionalUnits(3475, $this->getTwoDecimalDigitsCurrencyType()),
            ],
            [
                Currency::fromString('34.75', $this->getTwoDecimalDigitsCurrencyType()),
                Currency::fromDecimal(Decimal::fromString('34.75'), $this->getTwoDecimalDigitsCurrencyType()),
            ],
        ];
    }

    public function unequalCurrenciesProvider(): array
    {
        return [
            [
                Currency::fromString('34.75', $this->getTwoDecimalDigitsCurrencyType()),
                Currency::fromString('34.76', $this->getTwoDecimalDigitsCurrencyType()),
            ],
            [
                Currency::fromString('34.75', $this->getTwoDecimalDigitsCurrencyType()),
                Currency::fromFloat(34.76, $this->getTwoDecimalDigitsCurrencyType()),
            ],
            [
                Currency::fromString('34.75', $this->getTwoDecimalDigitsCurrencyType()),
                Currency::fromFractionalUnits(3476, $this->getTwoDecimalDigitsCurrencyType()),
            ],
            [
                Currency::fromString('34.75', $this->getTwoDecimalDigitsCurrencyType()),
                Currency::fromDecimal(Decimal::fromString('34.76'), $this->getTwoDecimalDigitsCurrencyType()),
            ],

            [
                Currency::fromString('34.75', $this->getTwoDecimalDigitsCurrencyType(false)),
                Currency::fromString('34.75', $this->getTwoDecimalDigitsCurrencyType(false)),
            ],
            [
                Currency::fromString('34.75', $this->getTwoDecimalDigitsCurrencyType(false)),
                Currency::fromFloat(34.75, $this->getTwoDecimalDigitsCurrencyType(false)),
            ],
            [
                Currency::fromString('34.75', $this->getTwoDecimalDigitsCurrencyType(false)),
                Currency::fromFractionalUnits(3475, $this->getTwoDecimalDigitsCurrencyType(false)),
            ],
            [
                Currency::fromString('34.75', $this->getTwoDecimalDigitsCurrencyType(false)),
                Currency::fromDecimal(Decimal::fromString('34.75'), $this->getTwoDecimalDigitsCurrencyType(false)),
            ],
        ];
    }

    private function getTwoDecimalDigitsCurrencyType(bool $equals = true): CurrencyType
    {
        /** @var CurrencyType|MockInterface $currencyType */
        $currencyType = \Mockery::mock(CurrencyType::class);

        $currencyType
            ->shouldReceive('getNumFractionalDigits')->andReturn(2)
            ->shouldReceive('equals')->andReturn($equals);

        return $currencyType;
    }
}
