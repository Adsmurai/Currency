<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\CurrencyTypeFactory;

use Adsmurai\Currency\Contracts\CurrencyType;
use Adsmurai\Currency\CurrencyTypeFactory;
use PHPUnit\Framework\TestCase;

class BuildFromISOCodeTests extends TestCase
{
    /**
     * @dataProvider commonCurrenciesProvider
     * @covers       \Adsmurai\Currency\CurrencyTypeFactory
     */
    public function test_with_common_currencies(string $ISOCode)
    {
        /** @var array $currencyData */
        $currencyData = $this->getCurrenciesData()[$ISOCode];
        $currencyTypeFactory = CurrencyTypeFactory::fromDataPath();

        $currencyType = $currencyTypeFactory->buildFromISOCode($ISOCode);

        $this->assertInstanceOf(CurrencyType::class, $currencyType);
        $this->assertEquals($ISOCode, $currencyType->getISOCode());
        $this->assertEquals($currencyData['symbol'], $currencyType->getSymbol());
        $this->assertEquals($currencyData['symbolPlacement'], $currencyType->getSymbolPlacement());
        $this->assertEquals($currencyData['numFractionalDigits'], $currencyType->getNumFractionalDigits());
    }

    private function getCurrenciesData(): array
    {
        /** @var array $currenciesData */
        $currenciesData = include __DIR__.'/../../src/Data/CurrencyTypes.php';

        return $currenciesData;
    }

    /**
     * @dataProvider commonCurrenciesProvider
     * @covers       \Adsmurai\Currency\CurrencyTypeFactory
     */
    public function test_that_there_are_no_multiple_instances_for_same_currency_type(string $ISOCode)
    {
        $currencyTypeFactory = CurrencyTypeFactory::fromDataPath();

        $currencyTypeA = $currencyTypeFactory->buildFromISOCode($ISOCode);
        $currencyTypeB = $currencyTypeFactory->buildFromISOCode($ISOCode);

        $this->assertSame($currencyTypeA, $currencyTypeB);
    }

    /**
     * @covers \Adsmurai\Currency\CurrencyTypeFactory::buildFromISOCode
     * @expectedException \Adsmurai\Currency\Errors\UnsupportedCurrencyISOCodeError
     * @expectedExceptionMessage Unsupported currency ISO code (USD)
     */
    public function test_that_an_exception_is_thrown_when_we_try_to_build_a_not_defined_currency_type()
    {
        $currencyTypeFactory = CurrencyTypeFactory::fromDataArray(['EUR' => [
            'numFractionalDigits' => 2,
            'symbol' => '€',
            'symbolPlacement' => CurrencyType::AFTER_PLACEMENT,
        ]]);

        $currencyTypeFactory->buildFromISOCode('USD');
    }

    public function commonCurrenciesProvider(): array
    {
        return \array_map(
            function (string $ISOCode) {
                return [$ISOCode];
            },
            \array_keys($this->getCurrenciesData())
        );
    }
}
