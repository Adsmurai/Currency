<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\CurrencyFactoriesLocator;

use Adsmurai\Currency\Contracts\MoneyFactory;
use Adsmurai\Currency\Contracts\Currency;
use Adsmurai\Currency\Contracts\CurrencyFactory;
use Adsmurai\Currency\MoneyFactoriesLocator;
use PHPUnit\Framework\TestCase;

class GetCurrencyFactoryTests extends TestCase
{
    /**
     * @covers \Adsmurai\Currency\MoneyFactoriesLocator::__construct
     * @covers \Adsmurai\Currency\MoneyFactoriesLocator::getMoneyFactory
     */
    public function test_that_getCurrencyFactory_returns_a_CurrencyFactory_instance()
    {
        $currencyFactoriesLocator = new MoneyFactoriesLocator($this->getCurrencyTypeFactoryMock());

        $this->assertInstanceOf(MoneyFactory::class, $currencyFactoriesLocator->getMoneyFactory('EUR'));
        $this->assertInstanceOf(MoneyFactory::class, $currencyFactoriesLocator->getMoneyFactory('USD'));
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
     * @covers \Adsmurai\Currency\MoneyFactoriesLocator::__construct
     * @covers \Adsmurai\Currency\MoneyFactoriesLocator::getMoneyFactory
     */
    public function test_that_getCurrencyFactory_returns_the_same_instance_for_the_same_parameters()
    {
        $currencyFactoriesLocator = new MoneyFactoriesLocator($this->getCurrencyTypeFactoryMock());

        $currencyFactoryA = $currencyFactoriesLocator->getMoneyFactory('EUR');
        $currencyFactoryB = $currencyFactoriesLocator->getMoneyFactory('EUR');

        $this->assertSame($currencyFactoryA, $currencyFactoryB);
    }
}
