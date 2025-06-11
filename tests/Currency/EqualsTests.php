<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Contracts\Money as CurrencyInterface;
use Adsmurai\Currency\Money;
use Litipk\BigNumbers\Decimal;
use PHPUnit\Framework\TestCase;

class EqualsTests extends TestCase
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
                Money::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
                Money::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
            ],
            [
                Money::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
                Money::fromFloat(34.75, CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
            ],
            [
                Money::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
                Money::fromFractionalUnits(3475, CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
            ],
            [
                Money::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
                Money::fromDecimal(
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
                Money::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
                Money::fromString('34.76', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
            ],
            [
                Money::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
                Money::fromFloat(34.76, CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
            ],
            [
                Money::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
                Money::fromFractionalUnits(3476, CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
            ],
            [
                Money::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()),
                Money::fromDecimal(
                    Decimal::fromString('34.76'),
                    CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType()
                ),
            ],

            [
                Money::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType(false)),
                Money::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType(false)),
            ],
            [
                Money::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType(false)),
                Money::fromFloat(34.75, CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType(false)),
            ],
            [
                Money::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType(false)),
                Money::fromFractionalUnits(
                    3475,
                    CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType(false)
                ),
            ],
            [
                Money::fromString('34.75', CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType(false)),
                Money::fromDecimal(
                    Decimal::fromString('34.75'),
                    CurrencyTypeMocks::getComparableTwoDecimalDigitsCurrencyType(false)
                ),
            ],
        ];
    }
}
