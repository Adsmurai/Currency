<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\CurrencyTypeFactory;

use Adsmurai\Currency\Contracts\CurrencyType;
use Adsmurai\Currency\CurrencyTypeFactory;
use PHPUnit\Framework\TestCase;

class GetSupportedCurrencyISOCodesTests extends TestCase
{
    /**
     * @covers \Adsmurai\Currency\CurrencyTypeFactory::getSupportedCurrencyISOCodes
     */
    public function test_that_returns_the_supported_currency_iso_codes()
    {
        $currencyTypeFactory = CurrencyTypeFactory::fromDataArray([
            'EUR' => [
                'numFractionalDigits' => 2,
                'symbol' => '€',
                'symbolPlacement' => CurrencyType::AFTER_PLACEMENT,
            ],
            'USD' => [
                'numFractionalDigits' => 2,
                'symbol' => '$',
                'symbolPlacement' => CurrencyType::BEFORE_PLACEMENT,
            ],
        ]);

        $this->assertCount(2, $currencyTypeFactory->getSupportedCurrencyISOCodes());
        $this->assertContains('EUR', $currencyTypeFactory->getSupportedCurrencyISOCodes());
        $this->assertContains('USD', $currencyTypeFactory->getSupportedCurrencyISOCodes());
    }
}
