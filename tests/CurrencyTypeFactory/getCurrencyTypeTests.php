<?php
declare(strict_types=1);

namespace Adsmurai\Currency\Tests\CurrenCyTypeFactory;

use Adsmurai\Currency\CurrencyTypeFactory;
use Adsmurai\Currency\Contracts\CurrencyType;
use PHPUnit\Framework\TestCase;

class getCurrencyTypeTests extends TestCase
{
    /**
     * @dataProvider commonCurrenciesProvider
     * @covers \Adsmurai\Currency\CurrencyTypeFactory
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

    /**
     * @dataProvider commonCurrenciesProvider
     * @covers \Adsmurai\Currency\CurrencyTypeFactory
     */
    public function test_that_there_are_no_multiple_instances_for_same_currency_type(string $ISOCode)
    {
        $currencyTypeFactory = CurrencyTypeFactory::fromDataPath();

        $currencyTypeA = $currencyTypeFactory->buildFromISOCode($ISOCode);
        $currencyTypeB = $currencyTypeFactory->buildFromISOCode($ISOCode);

        $this->assertSame($currencyTypeA, $currencyTypeB);
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

    private function getCurrenciesData(): array
    {
        /** @var array $currenciesData */
        $currenciesData = include __DIR__ . '/../../src/Data/CurrencyTypes.php';

        return $currenciesData;
    }
}
