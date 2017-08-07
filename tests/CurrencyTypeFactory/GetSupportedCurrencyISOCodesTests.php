<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\CurrencyTypeFactory;

use Adsmurai\Currency\Contracts\Currency;
use Adsmurai\Currency\CurrencyFactory;
use PHPUnit\Framework\TestCase;

class GetSupportedCurrencyISOCodesTests extends TestCase
{
    /**
     * @covers \Adsmurai\Currency\CurrencyFactory::getSupportedCurrencyISOCodes
     */
    public function test_that_returns_the_supported_currency_iso_codes()
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

        $this->assertCount(2, $currencyTypeFactory->getSupportedCurrencyISOCodes());
        $this->assertContains('EUR', $currencyTypeFactory->getSupportedCurrencyISOCodes());
        $this->assertContains('USD', $currencyTypeFactory->getSupportedCurrencyISOCodes());
    }
}
