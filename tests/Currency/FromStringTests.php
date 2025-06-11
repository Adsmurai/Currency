<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Contracts\Money as CurrencyInterface;
use Adsmurai\Currency\Contracts\Currency;
use Adsmurai\Currency\Money;
use PHPUnit\Framework\TestCase;

class FromStringTests extends TestCase
{
    /**
     * @dataProvider validParamsProvider
     * @covers       \Adsmurai\Currency\Money::fromString
     * @covers       \Adsmurai\Currency\Money::extractNumericAmount
     * @covers       \Adsmurai\Currency\Money::getAmountPlusIsoCodePattern
     * @covers       \Adsmurai\Currency\Money::getAmountPlusSymbolPattern
     * @covers       \Adsmurai\Currency\Money::__construct
     */
    public function test_with_valid_params(string $amount, Currency $currencyType)
    {
        $currency = Money::fromString($amount, $currencyType);

        $this->assertInstanceOf(CurrencyInterface::class, $currency);
        $this->assertInstanceOf(Money::class, $currency);
    }

    public function validParamsProvider(): array
    {
        $eurCurrencyType = CurrencyTypeMocks::getEuroCurrencyType();
        $usdCurrencyType = CurrencyTypeMocks::getUsDollarCurrencyType();
        $penCurrencyType = CurrencyTypeMocks::getPenCurrencyType();

        return [
            ['34.76', $eurCurrencyType],
            ['100', $eurCurrencyType],
            ['0.01', $eurCurrencyType],
            ['12345678.50', $eurCurrencyType],

            ['34.76', $usdCurrencyType],
            ['100', $usdCurrencyType],
            ['0.01', $usdCurrencyType],
            ['12345678.50', $usdCurrencyType],

            ['34.76', $penCurrencyType],
            ['100', $penCurrencyType],
            ['0.01', $penCurrencyType],
            ['12345678.50', $penCurrencyType],

            ['34.76 EUR', $eurCurrencyType],
            ['100 EUR', $eurCurrencyType],
            ['0.01 EUR', $eurCurrencyType],
            ['12345678.50 EUR', $eurCurrencyType],

            ['34.76 USD', $usdCurrencyType],
            ['100 USD', $usdCurrencyType],
            ['0.01 USD', $usdCurrencyType],
            ['12345678.50 USD', $usdCurrencyType],

            ['34.76 PEN', $penCurrencyType],
            ['100 PEN', $penCurrencyType],
            ['0.01 PEN', $penCurrencyType],
            ['12345678.50 PEN', $penCurrencyType],

            ['34.76 €', $eurCurrencyType],
            ['100 €', $eurCurrencyType],
            ['0.01 €', $eurCurrencyType],
            ['12345678.50 €', $eurCurrencyType],

            ['34.76€', $eurCurrencyType],
            ['100€', $eurCurrencyType],
            ['0.01€', $eurCurrencyType],
            ['12345678.50€', $eurCurrencyType],

            ['$ 34.76', $usdCurrencyType],
            ['$ 100', $usdCurrencyType],
            ['$ 0.01', $usdCurrencyType],
            ['$ 12345678.50', $usdCurrencyType],

            ['$34.76', $usdCurrencyType],
            ['$100', $usdCurrencyType],
            ['$0.01', $usdCurrencyType],
            ['$12345678.50', $usdCurrencyType],

            ['S/ 34.76', $penCurrencyType],
            ['S/ 100', $penCurrencyType],
            ['S/ 0.01', $penCurrencyType],
            ['S/ 12345678.50', $penCurrencyType],

            ['S/34.76', $penCurrencyType],
            ['S/100', $penCurrencyType],
            ['S/0.01', $penCurrencyType],
            ['S/12345678.50', $penCurrencyType],
        ];
    }

    /**
     * @dataProvider invalidParamsProvider
     * @covers       \Adsmurai\Currency\Money::fromString
     * @covers       \Adsmurai\Currency\Money::extractNumericAmount
     * @covers       \Adsmurai\Currency\Money::getAmountPlusIsoCodePattern
     * @covers       \Adsmurai\Currency\Money::getAmountPlusSymbolPattern
     */
    public function test_with_invalid_params(string $amount, Currency $currencyType)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid currency value');

        Money::fromString($amount, $currencyType);
    }

    public function invalidParamsProvider(): array
    {
        $eurCurrencyType = CurrencyTypeMocks::getEuroCurrencyType();
        $usdCurrencyType = CurrencyTypeMocks::getUsDollarCurrencyType();

        return [
            ['-34.76', $eurCurrencyType],
            ['-100', $eurCurrencyType],
            ['-0.01', $eurCurrencyType],
            ['-12345678.50', $eurCurrencyType],

            ['-34.76', $usdCurrencyType],
            ['-100', $usdCurrencyType],
            ['-0.01', $usdCurrencyType],
            ['-12345678.50', $usdCurrencyType],

            ['', $eurCurrencyType],
            ['hello world', $eurCurrencyType],
            ['45.035,56', $eurCurrencyType],
            ['45,035.56', $eurCurrencyType],

            ['', $usdCurrencyType],
            ['hello world', $usdCurrencyType],
            ['45.035,56', $usdCurrencyType],
            ['45,035.56', $usdCurrencyType],

            ['34.76 EUR', $usdCurrencyType],
            ['100 EUR', $usdCurrencyType],
            ['0.01 EUR', $usdCurrencyType],
            ['12345678.50 EUR', $usdCurrencyType],

            ['34.76 USD', $eurCurrencyType],
            ['100 USD', $eurCurrencyType],
            ['0.01 USD', $eurCurrencyType],
            ['12345678.50 USD', $eurCurrencyType],

            ['34.76 €', $usdCurrencyType],
            ['100 €', $usdCurrencyType],
            ['0.01 €', $usdCurrencyType],
            ['12345678.50 €', $usdCurrencyType],

            ['34.76 $', $eurCurrencyType],
            ['100 $', $eurCurrencyType],
            ['0.01 $', $eurCurrencyType],
            ['12345678.50 $', $eurCurrencyType],
        ];
    }
}
