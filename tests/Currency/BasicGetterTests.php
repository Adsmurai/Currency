<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Money;
use Litipk\BigNumbers\Decimal;
use PHPUnit\Framework\TestCase;

class BasicGetterTests extends TestCase
{
    /**
     * @covers \Adsmurai\Currency\Money::getAmountAsDecimal
     * @covers \Adsmurai\Currency\Money::getCurrency
     */
    public function test_basic_getters(): void
    {
        // @todo: Improve the test to decouple from Decimal. It requires refactoring Decimal.

        $amount = Decimal::fromString('34.56');
        $currencyType = CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType();

        $currency = Money::fromDecimal($amount, $currencyType);

        $this->assertSame($amount, $currency->getAmountAsDecimal());
        $this->assertSame($currencyType, $currency->getCurrency());
    }
}
