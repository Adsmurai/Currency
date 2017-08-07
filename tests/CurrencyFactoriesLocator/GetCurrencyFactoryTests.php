<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\CurrencyFactoriesLocator;

use Adsmurai\Currency\Contracts\MoneyFactory;
use Adsmurai\Currency\Contracts\Currency;
use Adsmurai\Currency\Contracts\CurrencyFactory;
use Adsmurai\Currency\CurrencyFactoriesLocator;
use PHPUnit\Framework\TestCase;

class GetCurrencyFactoryTests extends TestCase
{
    /**
     * @covers \Adsmurai\Currency\CurrencyFactoriesLocator::__construct
     * @covers \Adsmurai\Currency\CurrencyFactoriesLocator::getCurrencyFactory
     */
    public function test_that_getCurrencyFactory_returns_a_CurrencyFactory_instance()
    {
        $currencyFactoriesLocator = new CurrencyFactoriesLocator($this->getCurrencyTypeFactoryMock());

        $this->assertInstanceOf(MoneyFactory::class, $currencyFactoriesLocator->getCurrencyFactory('EUR'));
        $this->assertInstanceOf(MoneyFactory::class, $currencyFactoriesLocator->getCurrencyFactory('USD'));
    }

    /**
     * @return CurrencyFactory|\Mockery\MockInterface
     */
    private function getCurrencyTypeFactoryMock()
    {
        /** @var CurrencyFactory|\Mockery\MockInterface $currencyTypeFactory */
        $currencyTypeFactory = \Mockery::mock(CurrencyFactory::class);
        $currencyTypeFactory
            ->shouldReceive('buildFromISOCode')->andReturn(\Mockery::mock(Currency::class));

        return $currencyTypeFactory;
    }

    /**
     * @covers \Adsmurai\Currency\CurrencyFactoriesLocator::__construct
     * @covers \Adsmurai\Currency\CurrencyFactoriesLocator::getCurrencyFactory
     */
    public function test_that_getCurrencyFactory_returns_the_same_instance_for_the_same_parameters()
    {
        $currencyFactoriesLocator = new CurrencyFactoriesLocator($this->getCurrencyTypeFactoryMock());

        $currencyFactoryA = $currencyFactoriesLocator->getCurrencyFactory('EUR');
        $currencyFactoryB = $currencyFactoriesLocator->getCurrencyFactory('EUR');

        $this->assertSame($currencyFactoryA, $currencyFactoryB);
    }
}
