<?php

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Currency;
use Adsmurai\Currency\Interfaces\CurrencyType;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class formatTests extends TestCase
{
    /**
     * @dataProvider simpleParamsProvider
     * @covers \Adsmurai\Currency\Currency::format
     */
    public function test_format_without_custom_parameters(
        string $amount,
        CurrencyType $currencyType,
        string $formattedCurrency
    )
    {
        $currency = Currency::fromString($amount, $currencyType);
        $this->assertEquals($formattedCurrency, $currency->format());
    }

    /**
     * @dataProvider customizedParamsProvider
     * @covers \Adsmurai\Currency\Currency::format
     */
    public function test_format_with_custom_separators(
        string $amount,
        CurrencyType $currencyType,
        string $decimalsSeparator,
        string $thousandsSeparator,
        string $formattedCurrency
    )
    {
        $currency = Currency::fromString($amount, $currencyType);
        $this->assertEquals($formattedCurrency, $currency->format($decimalsSeparator, $thousandsSeparator));
    }

    public function simpleParamsProvider(): array
    {
        return [
            ['34.76', $this->getNDecimalDigitsCurrencyType(), '34.76€'],
            ['100', $this->getNDecimalDigitsCurrencyType(), '100.00€'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(), '0.01€'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(), '12345678.50€'],

            ['34.76', $this->getNDecimalDigitsCurrencyType(3), '34.760€'],
            ['100', $this->getNDecimalDigitsCurrencyType(3), '100.000€'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(3), '0.010€'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(3), '12345678.500€'],

            ['34.76', $this->getNDecimalDigitsCurrencyType(3, '$'), '34.760$'],
            ['100', $this->getNDecimalDigitsCurrencyType(3, '$'), '100.000$'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(3, '$'), '0.010$'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(3, '$'), '12345678.500$'],

            ['34.76', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT), '$34.760'],
            ['100', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT), '$100.000'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT), '$0.010'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT), '$12345678.500'],
        ];
    }

    public function customizedParamsProvider(): array
    {
        return [
            ['34.76', $this->getNDecimalDigitsCurrencyType(), ',', '.', '34,76€'],
            ['100', $this->getNDecimalDigitsCurrencyType(), ',', '.', '100,00€'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(), ',', '.', '0,01€'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(), ',', '.', '12.345.678,50€'],

            ['34.76', $this->getNDecimalDigitsCurrencyType(3), ',', '.', '34,760€'],
            ['100', $this->getNDecimalDigitsCurrencyType(3), ',', '.', '100,000€'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(3), ',', '.', '0,010€'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(3), ',', '.', '12.345.678,500€'],

            ['34.76', $this->getNDecimalDigitsCurrencyType(3, '$'), ',', '.', '34,760$'],
            ['100', $this->getNDecimalDigitsCurrencyType(3, '$'), ',', '.', '100,000$'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(3, '$'), ',', '.', '0,010$'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(3, '$'), ',', '.', '12.345.678,500$'],

            ['34.76', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT), ',', '.', '$34,760'],
            ['100', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT), ',', '.', '$100,000'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT), ',', '.', '$0,010'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT), ',', '.', '$12.345.678,500'],
        ];
    }

    private static function getNDecimalDigitsCurrencyType(
        int $n = 2,
        string $symbol = '€',
        int $symbolPlacement = CurrencyType::AFTER_PLACEMENT
    ): CurrencyType
    {
        /** @var CurrencyType|MockInterface $currencyType */
        $currencyType = \Mockery::mock(CurrencyType::class);

        $currencyType
            ->shouldReceive('getNumFractionalDigits')->andReturn($n)
            ->shouldReceive('getSymbol')->andReturn($symbol)
            ->shouldReceive('getSymbolPlacement')->andReturn($symbolPlacement);

        return $currencyType;
    }
}
