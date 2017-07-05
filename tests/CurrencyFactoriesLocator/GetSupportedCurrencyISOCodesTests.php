<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\CurrencyFactoriesLocator;

use Adsmurai\Currency\Contracts\CurrencyTypeFactory;
use Adsmurai\Currency\CurrencyFactoriesLocator;
use PHPUnit\Framework\TestCase;

class GetSupportedCurrencyISOCodesTests extends TestCase
{
    /**
     * @covers \Adsmurai\Currency\CurrencyFactoriesLocator::getSupportedCurrencyISOCodes
     */
    public function test()
    {
        /** @var \Mockery\MockInterface|CurrencyTypeFactory $currencyTypeFactory */
        $currencyTypeFactory = \Mockery::mock(CurrencyTypeFactory::class);
        $currencyTypeFactory->shouldReceive('getSupportedCurrencyISOCodes')->andReturn(['EUR', 'USD']);

        $currencyFactoriesLocator = new CurrencyFactoriesLocator($currencyTypeFactory);

        $this->assertCount(2, $currencyFactoriesLocator->getSupportedCurrencyISOCodes());
        $this->assertContains('EUR', $currencyFactoriesLocator->getSupportedCurrencyISOCodes());
        $this->assertContains('USD', $currencyFactoriesLocator->getSupportedCurrencyISOCodes());
    }
}
