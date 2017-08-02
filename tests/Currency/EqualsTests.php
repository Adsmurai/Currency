<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Contracts\Currency as CurrencyInterface;
use Adsmurai\Currency\Currency;
use Litipk\BigNumbers\Decimal;
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
                Currency::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
                Currency::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
            ],
            [
                Currency::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
                Currency::fromFloat(34.75, CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
            ],
            [
                Currency::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
                Currency::fromFractionalUnits(3475, CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
            ],
            [
                Currency::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
                Currency::fromDecimal(
                    Decimal::fromString('34.75'),
                    CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()
                ),
            ],
        ];
    }

    public function unequalCurrenciesProvider(): array
    {
        return [
            [
                Currency::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
                Currency::fromString('34.76', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
            ],
            [
                Currency::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
                Currency::fromFloat(34.76, CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
            ],
            [
                Currency::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
                Currency::fromFractionalUnits(3476, CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
            ],
            [
                Currency::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
                Currency::fromDecimal(
                    Decimal::fromString('34.76'),
                    CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()
                ),
            ],

            [
                Currency::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType(false)),
                Currency::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType(false)),
            ],
            [
                Currency::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType(false)),
                Currency::fromFloat(34.75, CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType(false)),
            ],
            [
                Currency::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType(false)),
                Currency::fromFractionalUnits(
                    3475,
                    CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType(false)
                ),
            ],
            [
                Currency::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType(false)),
                Currency::fromDecimal(
                    Decimal::fromString('34.75'),
                    CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType(false)
                ),
            ],
        ];
    }
}
