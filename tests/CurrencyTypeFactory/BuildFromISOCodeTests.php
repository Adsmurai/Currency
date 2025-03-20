<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\CurrencyTypeFactory;

use Adsmurai\Currency\Contracts\Currency;
use Adsmurai\Currency\CurrencyFactory;
use PHPUnit\Framework\TestCase;

class BuildFromISOCodeTests extends TestCase
{
    /**
     * @dataProvider commonCurrenciesProvider
     * @covers       \Adsmurai\Currency\CurrencyFactory
     */
    public function test_with_common_currencies(string $ISOCode)
    {
        /** @var array $currencyData */
        $currencyData = $this->getCurrenciesData()[$ISOCode];
        $currencyTypeFactory = CurrencyFactory::fromDataPath();

        $currencyType = $currencyTypeFactory->buildFromISOCode($ISOCode);

        $this->assertInstanceOf(Currency::class, $currencyType);
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
     * @covers       \Adsmurai\Currency\CurrencyFactory
     */
    public function test_that_there_are_no_multiple_instances_for_same_currency_type(string $ISOCode)
    {
        $currencyTypeFactory = CurrencyFactory::fromDataPath();

        $currencyTypeA = $currencyTypeFactory->buildFromISOCode($ISOCode);
        $currencyTypeB = $currencyTypeFactory->buildFromISOCode($ISOCode);

        $this->assertSame($currencyTypeA, $currencyTypeB);
    }

    /**
     * @covers \Adsmurai\Currency\CurrencyFactory::buildFromISOCode
     * @covers \Adsmurai\Currency\Errors\UnsupportedCurrencyISOCodeError
     */
    public function test_that_an_exception_is_thrown_when_we_try_to_build_a_not_defined_currency_type()
    {
        $this->expectException(\Adsmurai\Currency\Errors\UnsupportedCurrencyISOCodeError::class);
        $this->expectDeprecationMessage('Unsupported currency ISO code (USD)');

        $currencyTypeFactory = CurrencyFactory::fromDataArray(['EUR' => [
            'numFractionalDigits' => 2,
            'symbol' => '€',
            'symbolPlacement' => Currency::AFTER_PLACEMENT,
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
