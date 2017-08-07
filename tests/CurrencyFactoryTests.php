<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests;

use Adsmurai\Currency\Contracts\Money;
use Adsmurai\Currency\Contracts\Currency;
use Adsmurai\Currency\MoneyFactory;
use Adsmurai\Currency\CurrencyFactory;
use Litipk\BigNumbers\Decimal;
use PHPUnit\Framework\TestCase;

class CurrencyFactoryTests extends TestCase
{
    /**
     * @covers \Adsmurai\Currency\MoneyFactory
     */
    public function test_buildFromFloat()
    {
        $currencyType = $this->getCurrencyType();
        $currencyFactory = new MoneyFactory($currencyType);

        $currency = $currencyFactory->buildFromFloat(1.0);

        $this->assertInstanceOf(Money::class, $currency);
        $this->assertSame($currencyType, $currency->getCurrency());
    }

    private function getCurrencyType(): Currency
    {
        return CurrencyFactory::fromDataPath()->buildFromISOCode('EUR');
    }

    /**
     * @covers \Adsmurai\Currency\MoneyFactory
     */
    public function test_buildFromString()
    {
        $currencyType = $this->getCurrencyType();
        $currencyFactory = new MoneyFactory($currencyType);

        $currency = $currencyFactory->buildFromString('1.0');

        $this->assertInstanceOf(Money::class, $currency);
        $this->assertSame($currencyType, $currency->getCurrency());
    }

    /**
     * @covers \Adsmurai\Currency\MoneyFactory
     */
    public function test_buildFromFractionalUnits()
    {
        $currencyType = $this->getCurrencyType();
        $currencyFactory = new MoneyFactory($currencyType);

        $currency = $currencyFactory->buildFromFractionalUnits(100);

        $this->assertInstanceOf(Money::class, $currency);
        $this->assertSame($currencyType, $currency->getCurrency());
    }

    /**
     * @covers \Adsmurai\Currency\MoneyFactory
     */
    public function test_buildFromDecimal()
    {
        $currencyType = $this->getCurrencyType();
        $currencyFactory = new MoneyFactory($currencyType);

        $currency = $currencyFactory->buildFromDecimal(Decimal::fromFloat(1.0));

        $this->assertInstanceOf(Money::class, $currency);
        $this->assertSame($currencyType, $currency->getCurrency());
    }
}
