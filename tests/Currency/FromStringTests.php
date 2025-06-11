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
    public function test_with_valid_params(string $amount, Currency $currencyType): void
    {
        $currency = Money::fromString($amount, $currencyType);

        $this->assertInstanceOf(CurrencyInterface::class, $currency);
        $this->assertInstanceOf(Money::class, $currency);
    }

    public static function validParamsProvider(): \Iterator
    {
        $eurCurrencyType = CurrencyTypeMocks::getEuroCurrencyType();
        $usdCurrencyType = CurrencyTypeMocks::getUsDollarCurrencyType();
        $penCurrencyType = CurrencyTypeMocks::getPenCurrencyType();
        yield ['34.76', $eurCurrencyType];
        yield ['100', $eurCurrencyType];
        yield ['0.01', $eurCurrencyType];
        yield ['12345678.50', $eurCurrencyType];
        yield ['34.76', $usdCurrencyType];
        yield ['100', $usdCurrencyType];
        yield ['0.01', $usdCurrencyType];
        yield ['12345678.50', $usdCurrencyType];
        yield ['34.76', $penCurrencyType];
        yield ['100', $penCurrencyType];
        yield ['0.01', $penCurrencyType];
        yield ['12345678.50', $penCurrencyType];
        yield ['34.76 EUR', $eurCurrencyType];
        yield ['100 EUR', $eurCurrencyType];
        yield ['0.01 EUR', $eurCurrencyType];
        yield ['12345678.50 EUR', $eurCurrencyType];
        yield ['34.76 USD', $usdCurrencyType];
        yield ['100 USD', $usdCurrencyType];
        yield ['0.01 USD', $usdCurrencyType];
        yield ['12345678.50 USD', $usdCurrencyType];
        yield ['34.76 PEN', $penCurrencyType];
        yield ['100 PEN', $penCurrencyType];
        yield ['0.01 PEN', $penCurrencyType];
        yield ['12345678.50 PEN', $penCurrencyType];
        yield ['34.76 €', $eurCurrencyType];
        yield ['100 €', $eurCurrencyType];
        yield ['0.01 €', $eurCurrencyType];
        yield ['12345678.50 €', $eurCurrencyType];
        yield ['34.76€', $eurCurrencyType];
        yield ['100€', $eurCurrencyType];
        yield ['0.01€', $eurCurrencyType];
        yield ['12345678.50€', $eurCurrencyType];
        yield ['$ 34.76', $usdCurrencyType];
        yield ['$ 100', $usdCurrencyType];
        yield ['$ 0.01', $usdCurrencyType];
        yield ['$ 12345678.50', $usdCurrencyType];
        yield ['$34.76', $usdCurrencyType];
        yield ['$100', $usdCurrencyType];
        yield ['$0.01', $usdCurrencyType];
        yield ['$12345678.50', $usdCurrencyType];
        yield ['S/ 34.76', $penCurrencyType];
        yield ['S/ 100', $penCurrencyType];
        yield ['S/ 0.01', $penCurrencyType];
        yield ['S/ 12345678.50', $penCurrencyType];
        yield ['S/34.76', $penCurrencyType];
        yield ['S/100', $penCurrencyType];
        yield ['S/0.01', $penCurrencyType];
        yield ['S/12345678.50', $penCurrencyType];
    }

    /**
     * @dataProvider invalidParamsProvider
     * @covers       \Adsmurai\Currency\Money::fromString
     * @covers       \Adsmurai\Currency\Money::extractNumericAmount
     * @covers       \Adsmurai\Currency\Money::getAmountPlusIsoCodePattern
     * @covers       \Adsmurai\Currency\Money::getAmountPlusSymbolPattern
     */
    public function test_with_invalid_params(string $amount, Currency $currencyType): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid currency value');

        Money::fromString($amount, $currencyType);
    }

    public static function invalidParamsProvider(): \Iterator
    {
        $eurCurrencyType = CurrencyTypeMocks::getEuroCurrencyType();
        $usdCurrencyType = CurrencyTypeMocks::getUsDollarCurrencyType();
        yield ['-34.76', $eurCurrencyType];
        yield ['-100', $eurCurrencyType];
        yield ['-0.01', $eurCurrencyType];
        yield ['-12345678.50', $eurCurrencyType];
        yield ['-34.76', $usdCurrencyType];
        yield ['-100', $usdCurrencyType];
        yield ['-0.01', $usdCurrencyType];
        yield ['-12345678.50', $usdCurrencyType];
        yield ['', $eurCurrencyType];
        yield ['hello world', $eurCurrencyType];
        yield ['45.035,56', $eurCurrencyType];
        yield ['45,035.56', $eurCurrencyType];
        yield ['', $usdCurrencyType];
        yield ['hello world', $usdCurrencyType];
        yield ['45.035,56', $usdCurrencyType];
        yield ['45,035.56', $usdCurrencyType];
        yield ['34.76 EUR', $usdCurrencyType];
        yield ['100 EUR', $usdCurrencyType];
        yield ['0.01 EUR', $usdCurrencyType];
        yield ['12345678.50 EUR', $usdCurrencyType];
        yield ['34.76 USD', $eurCurrencyType];
        yield ['100 USD', $eurCurrencyType];
        yield ['0.01 USD', $eurCurrencyType];
        yield ['12345678.50 USD', $eurCurrencyType];
        yield ['34.76 €', $usdCurrencyType];
        yield ['100 €', $usdCurrencyType];
        yield ['0.01 €', $usdCurrencyType];
        yield ['12345678.50 €', $usdCurrencyType];
        yield ['34.76 $', $eurCurrencyType];
        yield ['100 $', $eurCurrencyType];
        yield ['0.01 $', $eurCurrencyType];
        yield ['12345678.50 $', $eurCurrencyType];
    }
}
