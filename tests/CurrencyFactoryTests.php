<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests;

use Adsmurai\Currency\CurrencyFactory;
use Adsmurai\Currency\CurrencyTypeFactory;
use Adsmurai\Currency\Contracts\Currency;
use Adsmurai\Currency\Contracts\CurrencyType;
use Litipk\BigNumbers\Decimal;
use PHPUnit\Framework\TestCase;

class CurrencyFactoryTests extends TestCase
{
    /**
     * @covers \Adsmurai\Currency\CurrencyFactory
     */
    public function test_buildFromFloat()
    {
        $currencyType = $this->getCurrencyType();
        $currencyFactory = new CurrencyFactory($currencyType);

        $currency = $currencyFactory->buildFromFloat(1.0);

        $this->assertInstanceOf(Currency::class, $currency);
        $this->assertSame($currencyType, $currency->getCurrencyType());
    }

    /**
     * @covers \Adsmurai\Currency\CurrencyFactory
     */
    public function test_buildFromString()
    {
        $currencyType = $this->getCurrencyType();
        $currencyFactory = new CurrencyFactory($currencyType);

        $currency = $currencyFactory->buildFromString('1.0');

        $this->assertInstanceOf(Currency::class, $currency);
        $this->assertSame($currencyType, $currency->getCurrencyType());
    }

    /**
     * @covers \Adsmurai\Currency\CurrencyFactory
     */
    public function test_buildFromFractionalUnits()
    {
        $currencyType = $this->getCurrencyType();
        $currencyFactory = new CurrencyFactory($currencyType);

        $currency = $currencyFactory->buildFromFractionalUnits(100);

        $this->assertInstanceOf(Currency::class, $currency);
        $this->assertSame($currencyType, $currency->getCurrencyType());
    }

    /**
     * @covers \Adsmurai\Currency\CurrencyFactory
     */
    public function test_buildFromDecimal()
    {
        $currencyType = $this->getCurrencyType();
        $currencyFactory = new CurrencyFactory($currencyType);

        $currency = $currencyFactory->buildFromDecimal(Decimal::fromFloat(1.0));

        $this->assertInstanceOf(Currency::class, $currency);
        $this->assertSame($currencyType, $currency->getCurrencyType());
    }

    private function getCurrencyType(): CurrencyType
    {
        return CurrencyTypeFactory::fromDataPath()->buildFromISOCode('EUR');
    }
}
