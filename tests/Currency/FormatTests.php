<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Currency;
use Adsmurai\Currency\Contracts\CurrencyType;
use Adsmurai\Currency\CurrencyFormat;
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
    ) {
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
    ) {
        $currency = Currency::fromString($amount, $currencyType);
        $currencyFormat = new CurrencyFormat($decimalsSeparator, $thousandsSeparator);
        $this->assertEquals($formattedCurrency, $currency->format($currencyFormat));
    }

    /**
     * @dataProvider extraPrecisionParamsProvider
     * @covers \Adsmurai\Currency\Currency::format
     */
    public function test_format_with_extra_precision(
        string $amount,
        CurrencyType $currencyType,
        int $extraPrecision,
        string $formattedCurrency
    ) {
        $currency = Currency::fromString($amount, $currencyType);
        $currencyFormat = new CurrencyFormat('.', '', $extraPrecision);
        $this->assertEquals($formattedCurrency, $currency->format($currencyFormat));
    }

    /**
     * @dataProvider precisionParamsProvider
     * @covers \Adsmurai\Currency\Currency::format
     */
    public function test_format_with_custom_precision(
        string $amount,
        CurrencyType $currencyType,
        int $extraPrecision,
        string $formattedCurrency
    ) {
        $currency = Currency::fromString($amount, $currencyType);
        $currencyFormat = new CurrencyFormat('.', '', 3, 1, $extraPrecision);
        $this->assertEquals($formattedCurrency, $currency->format($currencyFormat));
    }

    /**
     * @dataProvider noDecorationParamsProvider
     * @covers \Adsmurai\Currency\Currency::format
     */
    public function test_format_with_no_decoration(
        string $amount,
        CurrencyType $currencyType,
        string $formattedCurrency
    ) {
        //$this->markTestSkipped();
        $currency = Currency::fromString($amount, $currencyType);
        $currencyFormat = new CurrencyFormat('.', '', 0, CurrencyFormat::DECORATION_NO_DECORATION);
        $this->assertEquals($formattedCurrency, $currency->format($currencyFormat));
    }

    /**
     * @dataProvider isoCodeDecorationParamsProvider
     * @covers \Adsmurai\Currency\Currency::format
     */
    public function test_format_with_decoration_iso_code(
        string $amount,
        CurrencyType $currencyType,
        string $formattedCurrency
    ) {
        $currency = Currency::fromString($amount, $currencyType);
        $currencyFormat = new CurrencyFormat('.', '', 0, CurrencyFormat::DECORATION_ISO_CODE);
        $this->assertEquals($formattedCurrency, $currency->format($currencyFormat));
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

            ['34.761', $this->getNDecimalDigitsCurrencyType(), '34.76€'],
            ['34.766', $this->getNDecimalDigitsCurrencyType(), '34.77€'],
            ['100.002', $this->getNDecimalDigitsCurrencyType(), '100.00€'],
            ['100.008', $this->getNDecimalDigitsCurrencyType(), '100.01€'],
            ['0.014', $this->getNDecimalDigitsCurrencyType(), '0.01€'],
            ['0.017', $this->getNDecimalDigitsCurrencyType(), '0.02€'],
            ['12345678.503', $this->getNDecimalDigitsCurrencyType(), '12345678.50€'],
            ['12345678.509', $this->getNDecimalDigitsCurrencyType(), '12345678.51€'],
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

    public function extraPrecisionParamsProvider(): array
    {
        return [
            ['34.76', $this->getNDecimalDigitsCurrencyType(), 2, '34.7600€'],
            ['100', $this->getNDecimalDigitsCurrencyType(), 2, '100.0000€'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(), 2, '0.0100€'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(), 2, '12345678.5000€'],

            ['34.76', $this->getNDecimalDigitsCurrencyType(3), 2, '34.76000€'],
            ['100', $this->getNDecimalDigitsCurrencyType(3), 2, '100.00000€'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(3), 2, '0.01000€'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(3), 2, '12345678.50000€'],

            ['34.76', $this->getNDecimalDigitsCurrencyType(3, '$'), 2, '34.76000$'],
            ['100', $this->getNDecimalDigitsCurrencyType(3, '$'), 2, '100.00000$'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(3, '$'), 2, '0.01000$'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(3, '$'), 2, '12345678.50000$'],

            ['34.76', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT), 2, '$34.76000'],
            ['100', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT), 2, '$100.00000'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT), 2, '$0.01000'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT), 2, '$12345678.50000'],
        ];
    }

    public function precisionParamsProvider(): array
    {
        return [
            ['34.76', $this->getNDecimalDigitsCurrencyType(), 2, '34.76€'],
            ['100', $this->getNDecimalDigitsCurrencyType(), 2, '100.00€'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(), 2, '0.01€'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(), 2, '12345678.50€'],

            ['34.76', $this->getNDecimalDigitsCurrencyType(3), 2, '34.76€'],
            ['100', $this->getNDecimalDigitsCurrencyType(3), 2, '100.00€'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(3), 2, '0.01€'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(3), 2, '12345678.50€'],

            ['34.76', $this->getNDecimalDigitsCurrencyType(3, '$'), 2, '34.76$'],
            ['100', $this->getNDecimalDigitsCurrencyType(3, '$'), 2, '100.00$'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(3, '$'), 2, '0.01$'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(3, '$'), 2, '12345678.50$'],

            ['34.76', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT), 2, '$34.76'],
            ['100', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT), 2, '$100.00'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT), 2, '$0.01'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT), 2, '$12345678.50'],
        ];
    }

    public function noDecorationParamsProvider(): array
    {
        return [
            ['34.76', $this->getNDecimalDigitsCurrencyType(), '34.76'],
            ['100', $this->getNDecimalDigitsCurrencyType(), '100.00'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(), '0.01'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(), '12345678.50'],

            ['34.76', $this->getNDecimalDigitsCurrencyType(3), '34.760'],
            ['100', $this->getNDecimalDigitsCurrencyType(3), '100.000'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(3), '0.010'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(3), '12345678.500'],

            ['34.76', $this->getNDecimalDigitsCurrencyType(3, '$'), '34.760'],
            ['100', $this->getNDecimalDigitsCurrencyType(3, '$'), '100.000'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(3, '$'), '0.010'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(3, '$'), '12345678.500'],

            ['34.76', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT), '34.760'],
            ['100', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT), '100.000'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT), '0.010'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT), '12345678.500'],

            ['34.761', $this->getNDecimalDigitsCurrencyType(), '34.76'],
            ['34.766', $this->getNDecimalDigitsCurrencyType(), '34.77'],
            ['100.002', $this->getNDecimalDigitsCurrencyType(), '100.00'],
            ['100.008', $this->getNDecimalDigitsCurrencyType(), '100.01'],
            ['0.014', $this->getNDecimalDigitsCurrencyType(), '0.01'],
            ['0.017', $this->getNDecimalDigitsCurrencyType(), '0.02'],
            ['12345678.503', $this->getNDecimalDigitsCurrencyType(), '12345678.50'],
            ['12345678.509', $this->getNDecimalDigitsCurrencyType(), '12345678.51'],
        ];
    }

    public function isoCodeDecorationParamsProvider(): array
    {
        return [
            ['34.76', $this->getNDecimalDigitsCurrencyType(), '34.76EUR'],
            ['100', $this->getNDecimalDigitsCurrencyType(), '100.00EUR'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(), '0.01EUR'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(), '12345678.50EUR'],

            ['34.76', $this->getNDecimalDigitsCurrencyType(3), '34.760EUR'],
            ['100', $this->getNDecimalDigitsCurrencyType(3), '100.000EUR'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(3), '0.010EUR'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(3), '12345678.500EUR'],

            ['34.76', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::AFTER_PLACEMENT, 'USD'), '34.760USD'],
            ['100', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::AFTER_PLACEMENT, 'USD'), '100.000USD'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::AFTER_PLACEMENT, 'USD'), '0.010USD'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::AFTER_PLACEMENT, 'USD'), '12345678.500USD'],

            ['34.76', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT, 'USD'), '34.760USD'],
            ['100', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT, 'USD'), '100.000USD'],
            ['0.01', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT, 'USD'), '0.010USD'],
            ['12345678.50', $this->getNDecimalDigitsCurrencyType(3, '$', CurrencyType::BEFORE_PLACEMENT, 'USD'), '12345678.500USD'],

            ['34.761', $this->getNDecimalDigitsCurrencyType(), '34.76EUR'],
            ['34.766', $this->getNDecimalDigitsCurrencyType(), '34.77EUR'],
            ['100.002', $this->getNDecimalDigitsCurrencyType(), '100.00EUR'],
            ['100.008', $this->getNDecimalDigitsCurrencyType(), '100.01EUR'],
            ['0.014', $this->getNDecimalDigitsCurrencyType(), '0.01EUR'],
            ['0.017', $this->getNDecimalDigitsCurrencyType(), '0.02EUR'],
            ['12345678.503', $this->getNDecimalDigitsCurrencyType(), '12345678.50EUR'],
            ['12345678.509', $this->getNDecimalDigitsCurrencyType(), '12345678.51EUR'],
        ];
    }

    private static function getNDecimalDigitsCurrencyType(
        int $n = 2,
        string $symbol = '€',
        int $symbolPlacement = CurrencyType::AFTER_PLACEMENT,
        string $isoCode = 'EUR'
    ): CurrencyType {
        /** @var CurrencyType|MockInterface $currencyType */
        $currencyType = \Mockery::mock(CurrencyType::class);

        $currencyType
            ->shouldReceive('getNumFractionalDigits')->andReturn($n)
            ->shouldReceive('getSymbol')->andReturn($symbol)
            ->shouldReceive('getSymbolPlacement')->andReturn($symbolPlacement)
            ->shouldReceive('getISOCode')->andReturn($isoCode);

        return $currencyType;
    }
}
