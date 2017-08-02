<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Contracts\Currency as CurrencyInterface;
use Adsmurai\Currency\Contracts\CurrencyType;
use Adsmurai\Currency\Currency;
use PHPUnit\Framework\TestCase;

class fromStringTests extends TestCase
{
    /**
     * @dataProvider validParamsProvider
     * @covers       \Adsmurai\Currency\Currency::fromString
     * @covers       \Adsmurai\Currency\Currency::extractNumericAmount
     * @covers       \Adsmurai\Currency\Currency::getAmountPlusIsoCodePattern
     * @covers       \Adsmurai\Currency\Currency::getAmountPlusSymbolPattern
     * @covers       \Adsmurai\Currency\Currency::__construct
     */
    public function test_with_valid_params(string $amount, CurrencyType $currencyType)
    {
        $currency = Currency::fromString($amount, $currencyType);

        $this->assertInstanceOf(CurrencyInterface::class, $currency);
        $this->assertInstanceOf(Currency::class, $currency);
    }

    public function validParamsProvider(): array
    {
        $eurCurrencyType = CurrencyTypeMocks::getEuroCurrencyType();
        $usdCurrencyType = CurrencyTypeMocks::getUsDollarCurrencyType();

        return [
            ['34.76', $eurCurrencyType],
            ['100', $eurCurrencyType],
            ['0.01', $eurCurrencyType],
            ['12345678.50', $eurCurrencyType],

            ['34.76', $usdCurrencyType],
            ['100', $usdCurrencyType],
            ['0.01', $usdCurrencyType],
            ['12345678.50', $usdCurrencyType],

            ['34.76 EUR', $eurCurrencyType],
            ['100 EUR', $eurCurrencyType],
            ['0.01 EUR', $eurCurrencyType],
            ['12345678.50 EUR', $eurCurrencyType],

            ['34.76 USD', $usdCurrencyType],
            ['100 USD', $usdCurrencyType],
            ['0.01 USD', $usdCurrencyType],
            ['12345678.50 USD', $usdCurrencyType],

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
        ];
    }

    /**
     * @dataProvider invalidParamsProvider
     * @covers       \Adsmurai\Currency\Currency::fromString
     * @covers       \Adsmurai\Currency\Currency::extractNumericAmount
     * @covers       \Adsmurai\Currency\Currency::getAmountPlusIsoCodePattern
     * @covers       \Adsmurai\Currency\Currency::getAmountPlusSymbolPattern
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid currency value
     */
    public function test_with_invalid_params(string $amount, CurrencyType $currencyType)
    {
        Currency::fromString($amount, $currencyType);
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
