<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Currency;
use Litipk\BigNumbers\Decimal;
use PHPUnit\Framework\TestCase;

class BasicGetterTests extends TestCase
{
    /**
     * @covers \Adsmurai\Currency\Currency::getAmountAsDecimal
     * @covers \Adsmurai\Currency\Currency::getCurrencyType
     */
    public function test_basic_getters()
    {
        // @todo: Improve the test to decouple from Decimal. It requires refactoring Decimal.

        $amount = Decimal::fromString('34.56');
        $currencyType = CurrencyTypeMocks::getTwoDecimalDigitsCurrencyType();

        $currency = Currency::fromDecimal($amount, $currencyType);

        $this->assertSame($amount, $currency->getAmountAsDecimal());
        $this->assertSame($currencyType, $currency->getCurrencyType());
    }
}
