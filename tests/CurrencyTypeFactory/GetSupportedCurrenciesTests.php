<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\CurrencyTypeFactory;

use Adsmurai\Currency\Contracts\Currency;
use Adsmurai\Currency\CurrencyFactory;
use PHPUnit\Framework\TestCase;

class GetSupportedCurrenciesTests extends TestCase
{
    /**
     * @covers \Adsmurai\Currency\CurrencyFactory::getSupportedCurrencies
     */
    public function test_that_returns_the_supported_currencies(): void
    {
        $currencyTypeFactory = CurrencyFactory::fromDataArray([
            'EUR' => [
                'numFractionalDigits' => 2,
                'symbol' => '€',
                'symbolPlacement' => Currency::AFTER_PLACEMENT,
            ],
            'USD' => [
                'numFractionalDigits' => 2,
                'symbol' => '$',
                'symbolPlacement' => Currency::BEFORE_PLACEMENT,
            ],
        ]);

        $this->assertCount(2, $currencyTypeFactory->getSupportedCurrencies());
        $this->assertInstanceOf(Currency::class, $currencyTypeFactory->getSupportedCurrencies()[0]);
        $this->assertInstanceOf(Currency::class, $currencyTypeFactory->getSupportedCurrencies()[1]);
    }
}
