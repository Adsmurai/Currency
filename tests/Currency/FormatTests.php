<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Contracts\Currency;
use Adsmurai\Currency\Money;
use Adsmurai\Currency\MoneyFormat;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class FormatTests extends TestCase
{
    /**
     * @dataProvider simpleParamsProvider
     * @covers       \Adsmurai\Currency\Money::format
     * @covers       \Adsmurai\Currency\Money::decorate
     */
    public function test_format_without_custom_parameters(
        string $amount,
        Currency $currencyType,
        string $formattedCurrency
    ): void {
        $currency = Money::fromString($amount, $currencyType);
        $this->assertSame($formattedCurrency, $currency->format());
    }

    /**
     * @dataProvider customizedParamsProvider
     * @covers       \Adsmurai\Currency\Money::format
     * @covers       \Adsmurai\Currency\Money::decorate
     */
    public function test_format_with_custom_separators(
        string $amount,
        Currency $currencyType,
        string $decimalsSeparator,
        string $thousandsSeparator,
        string $formattedCurrency
    ): void {
        $currency = Money::fromString($amount, $currencyType);
        $currencyFormat = MoneyFormat::fromParameters($decimalsSeparator, $thousandsSeparator);
        $this->assertSame($formattedCurrency, $currency->format($currencyFormat));
    }

    /**
     * @dataProvider extraPrecisionParamsProvider
     * @covers       \Adsmurai\Currency\Money::format
     * @covers       \Adsmurai\Currency\Money::decorate
     */
    public function test_format_with_extra_precision(
        string $amount,
        Currency $currencyType,
        int $extraPrecision,
        string $formattedCurrency
    ): void {
        $currency = Money::fromString($amount, $currencyType);
        $currencyFormat = MoneyFormat::fromParametersWithExtraPrecision($extraPrecision);
        $this->assertSame($formattedCurrency, $currency->format($currencyFormat));
    }

    /**
     * @dataProvider precisionParamsProvider
     * @covers       \Adsmurai\Currency\Money::format
     * @covers       \Adsmurai\Currency\Money::decorate
     */
    public function test_format_with_custom_precision(
        string $amount,
        Currency $currencyType,
        int $precision,
        string $formattedCurrency
    ): void {
        $currency = Money::fromString($amount, $currencyType);
        $currencyFormat = MoneyFormat::fromParametersWithPrecision($precision);
        $this->assertSame($formattedCurrency, $currency->format($currencyFormat));
    }

    /**
     * @dataProvider noDecorationParamsProvider
     * @covers       \Adsmurai\Currency\Money::format
     * @covers       \Adsmurai\Currency\Money::decorate
     */
    public function test_format_with_no_decoration(
        string $amount,
        Currency $currencyType,
        string $formattedCurrency
    ): void {
        $currency = Money::fromString($amount, $currencyType);
        $currencyFormat = MoneyFormat::fromParameters(
            MoneyFormat::DEFAULT_DECIMALS_SEPARATOR,
            MoneyFormat::DEFAULT_THOUSANDS_SEPARATOR,
            MoneyFormat::DECORATION_NO_DECORATION
        );
        $this->assertSame($formattedCurrency, $currency->format($currencyFormat));
    }

    /**
     * @dataProvider isoCodeDecorationParamsProvider
     * @covers       \Adsmurai\Currency\Money::format
     * @covers       \Adsmurai\Currency\Money::decorate
     */
    public function test_format_with_decoration_iso_code(
        string $amount,
        Currency $currencyType,
        string $formattedCurrency
    ): void {
        $currency = Money::fromString($amount, $currencyType);
        $currencyFormat = MoneyFormat::fromParameters(
            MoneyFormat::DEFAULT_DECIMALS_SEPARATOR,
            MoneyFormat::DEFAULT_THOUSANDS_SEPARATOR,
            MoneyFormat::DECORATION_ISO_CODE
        );
        $this->assertSame($formattedCurrency, $currency->format($currencyFormat));
    }

    /**
     * @dataProvider spaceDecorationParamsProvider
     * @covers       \Adsmurai\Currency\Money::format
     * @covers       \Adsmurai\Currency\Money::decorate
     */
    public function test_format_with_separator(
        string $amount,
        Currency $currencyType,
        string $formattedCurrency,
        int $decorationSpace,
        int $decorationType
    ): void {
        $currency = Money::fromString($amount, $currencyType);
        $currencyFormat = MoneyFormat::fromParameters(
            MoneyFormat::DEFAULT_DECIMALS_SEPARATOR,
            MoneyFormat::DEFAULT_THOUSANDS_SEPARATOR,
            $decorationType,
            $decorationSpace
        );
        $this->assertSame($formattedCurrency, $currency->format($currencyFormat));
    }

    public static function simpleParamsProvider(): \Iterator
    {
        yield ['34.76', self::getNDecimalDigitsCurrencyType(), '34.76€'];
        yield ['100', self::getNDecimalDigitsCurrencyType(), '100.00€'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(), '0.01€'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(), '12345678.50€'];
        yield ['34.76', self::getNDecimalDigitsCurrencyType(3), '34.760€'];
        yield ['100', self::getNDecimalDigitsCurrencyType(3), '100.000€'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(3), '0.010€'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(3), '12345678.500€'];
        yield ['34.76', self::getNDecimalDigitsCurrencyType(3, '$'), '34.760$'];
        yield ['100', self::getNDecimalDigitsCurrencyType(3, '$'), '100.000$'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(3, '$'), '0.010$'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(3, '$'), '12345678.500$'];
        yield ['34.76', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT), '$34.760'];
        yield ['100', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT), '$100.000'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT), '$0.010'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT), '$12345678.500'];
        yield ['34.761', self::getNDecimalDigitsCurrencyType(), '34.76€'];
        yield ['34.766', self::getNDecimalDigitsCurrencyType(), '34.77€'];
        yield ['100.002', self::getNDecimalDigitsCurrencyType(), '100.00€'];
        yield ['100.008', self::getNDecimalDigitsCurrencyType(), '100.01€'];
        yield ['0.014', self::getNDecimalDigitsCurrencyType(), '0.01€'];
        yield ['0.017', self::getNDecimalDigitsCurrencyType(), '0.02€'];
        yield ['12345678.503', self::getNDecimalDigitsCurrencyType(), '12345678.50€'];
        yield ['12345678.509', self::getNDecimalDigitsCurrencyType(), '12345678.51€'];
    }

    private static function getNDecimalDigitsCurrencyType(
        int $n = 2,
        string $symbol = '€',
        int $symbolPlacement = Currency::AFTER_PLACEMENT,
        string $isoCode = 'EUR'
    ): Currency {
        /** @var Currency|MockInterface $currencyType */
        $currencyType = \Mockery::mock(Currency::class);

        $currencyType
            ->shouldReceive('getNumFractionalDigits')->andReturn($n)
            ->shouldReceive('getSymbol')->andReturn($symbol)
            ->shouldReceive('getSymbolPlacement')->andReturn($symbolPlacement)
            ->shouldReceive('getISOCode')->andReturn($isoCode);

        return $currencyType;
    }

    public static function customizedParamsProvider(): \Iterator
    {
        yield ['34.76', self::getNDecimalDigitsCurrencyType(), ',', '.', '34,76€'];
        yield ['100', self::getNDecimalDigitsCurrencyType(), ',', '.', '100,00€'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(), ',', '.', '0,01€'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(), ',', '.', '12.345.678,50€'];
        yield ['34.76', self::getNDecimalDigitsCurrencyType(3), ',', '.', '34,760€'];
        yield ['100', self::getNDecimalDigitsCurrencyType(3), ',', '.', '100,000€'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(3), ',', '.', '0,010€'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(3), ',', '.', '12.345.678,500€'];
        yield ['34.76', self::getNDecimalDigitsCurrencyType(3, '$'), ',', '.', '34,760$'];
        yield ['100', self::getNDecimalDigitsCurrencyType(3, '$'), ',', '.', '100,000$'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(3, '$'), ',', '.', '0,010$'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(3, '$'), ',', '.', '12.345.678,500$'];
        yield ['34.76', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT), ',', '.', '$34,760'];
        yield ['100', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT), ',', '.', '$100,000'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT), ',', '.', '$0,010'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT), ',', '.', '$12.345.678,500'];
    }

    public static function extraPrecisionParamsProvider(): \Iterator
    {
        yield ['34.76', self::getNDecimalDigitsCurrencyType(), 2, '34.7600€'];
        yield ['100', self::getNDecimalDigitsCurrencyType(), 2, '100.0000€'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(), 2, '0.0100€'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(), 2, '12345678.5000€'];
        yield ['34.76', self::getNDecimalDigitsCurrencyType(3), 2, '34.76000€'];
        yield ['100', self::getNDecimalDigitsCurrencyType(3), 2, '100.00000€'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(3), 2, '0.01000€'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(3), 2, '12345678.50000€'];
        yield ['34.76', self::getNDecimalDigitsCurrencyType(3, '$'), 2, '34.76000$'];
        yield ['100', self::getNDecimalDigitsCurrencyType(3, '$'), 2, '100.00000$'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(3, '$'), 2, '0.01000$'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(3, '$'), 2, '12345678.50000$'];
        yield ['34.76', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT), 2, '$34.76000'];
        yield ['100', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT), 2, '$100.00000'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT), 2, '$0.01000'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT), 2, '$12345678.50000'];
    }

    public static function precisionParamsProvider(): \Iterator
    {
        yield ['34.76', self::getNDecimalDigitsCurrencyType(), 2, '34.76€'];
        yield ['100', self::getNDecimalDigitsCurrencyType(), 2, '100.00€'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(), 2, '0.01€'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(), 2, '12345678.50€'];
        yield ['34.76', self::getNDecimalDigitsCurrencyType(3), 2, '34.76€'];
        yield ['100', self::getNDecimalDigitsCurrencyType(3), 2, '100.00€'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(3), 2, '0.01€'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(3), 2, '12345678.50€'];
        yield ['34.76', self::getNDecimalDigitsCurrencyType(3, '$'), 2, '34.76$'];
        yield ['100', self::getNDecimalDigitsCurrencyType(3, '$'), 2, '100.00$'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(3, '$'), 2, '0.01$'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(3, '$'), 2, '12345678.50$'];
        yield ['34.76', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT), 2, '$34.76'];
        yield ['100', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT), 2, '$100.00'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT), 2, '$0.01'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT), 2, '$12345678.50'];
    }

    public static function noDecorationParamsProvider(): \Iterator
    {
        yield ['34.76', self::getNDecimalDigitsCurrencyType(), '34.76'];
        yield ['100', self::getNDecimalDigitsCurrencyType(), '100.00'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(), '0.01'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(), '12345678.50'];
        yield ['34.76', self::getNDecimalDigitsCurrencyType(3), '34.760'];
        yield ['100', self::getNDecimalDigitsCurrencyType(3), '100.000'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(3), '0.010'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(3), '12345678.500'];
        yield ['34.76', self::getNDecimalDigitsCurrencyType(3, '$'), '34.760'];
        yield ['100', self::getNDecimalDigitsCurrencyType(3, '$'), '100.000'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(3, '$'), '0.010'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(3, '$'), '12345678.500'];
        yield ['34.76', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT), '34.760'];
        yield ['100', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT), '100.000'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT), '0.010'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT), '12345678.500'];
        yield ['34.761', self::getNDecimalDigitsCurrencyType(), '34.76'];
        yield ['34.766', self::getNDecimalDigitsCurrencyType(), '34.77'];
        yield ['100.002', self::getNDecimalDigitsCurrencyType(), '100.00'];
        yield ['100.008', self::getNDecimalDigitsCurrencyType(), '100.01'];
        yield ['0.014', self::getNDecimalDigitsCurrencyType(), '0.01'];
        yield ['0.017', self::getNDecimalDigitsCurrencyType(), '0.02'];
        yield ['12345678.503', self::getNDecimalDigitsCurrencyType(), '12345678.50'];
        yield ['12345678.509', self::getNDecimalDigitsCurrencyType(), '12345678.51'];
    }

    public static function isoCodeDecorationParamsProvider(): \Iterator
    {
        yield ['34.76', self::getNDecimalDigitsCurrencyType(), '34.76EUR'];
        yield ['100', self::getNDecimalDigitsCurrencyType(), '100.00EUR'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(), '0.01EUR'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(), '12345678.50EUR'];
        yield ['34.76', self::getNDecimalDigitsCurrencyType(3), '34.760EUR'];
        yield ['100', self::getNDecimalDigitsCurrencyType(3), '100.000EUR'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(3), '0.010EUR'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(3), '12345678.500EUR'];
        yield ['34.76', self::getNDecimalDigitsCurrencyType(3, '$', Currency::AFTER_PLACEMENT, 'USD'), '34.760USD'];
        yield ['100', self::getNDecimalDigitsCurrencyType(3, '$', Currency::AFTER_PLACEMENT, 'USD'), '100.000USD'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(3, '$', Currency::AFTER_PLACEMENT, 'USD'), '0.010USD'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(3, '$', Currency::AFTER_PLACEMENT, 'USD'), '12345678.500USD'];
        yield ['34.76', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT, 'USD'), '34.760USD'];
        yield ['100', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT, 'USD'), '100.000USD'];
        yield ['0.01', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT, 'USD'), '0.010USD'];
        yield ['12345678.50', self::getNDecimalDigitsCurrencyType(3, '$', Currency::BEFORE_PLACEMENT, 'USD'), '12345678.500USD'];
        yield ['34.761', self::getNDecimalDigitsCurrencyType(), '34.76EUR'];
        yield ['34.766', self::getNDecimalDigitsCurrencyType(), '34.77EUR'];
        yield ['100.002', self::getNDecimalDigitsCurrencyType(), '100.00EUR'];
        yield ['100.008', self::getNDecimalDigitsCurrencyType(), '100.01EUR'];
        yield ['0.014', self::getNDecimalDigitsCurrencyType(), '0.01EUR'];
        yield ['0.017', self::getNDecimalDigitsCurrencyType(), '0.02EUR'];
        yield ['12345678.503', self::getNDecimalDigitsCurrencyType(), '12345678.50EUR'];
        yield ['12345678.509', self::getNDecimalDigitsCurrencyType(), '12345678.51EUR'];
    }

    public static function spaceDecorationParamsProvider(): \Iterator
    {
        yield [
            '34.76',
            self::getNDecimalDigitsCurrencyType(),
            '34.76 €',
            MoneyFormat::DECORATION_WITH_SPACE,
            MoneyFormat::DECORATION_SYMBOL,
        ];
        yield [
            '34.76',
            self::getNDecimalDigitsCurrencyType(),
            '34.76€',
            MoneyFormat::DECORATION_WITHOUT_SPACE,
            MoneyFormat::DECORATION_SYMBOL,
        ];
        yield [
            '34.76',
            self::getNDecimalDigitsCurrencyType(),
            '34.76 EUR',
            MoneyFormat::DECORATION_WITH_SPACE,
            MoneyFormat::DECORATION_ISO_CODE,
        ];
        yield [
            '34.76',
            self::getNDecimalDigitsCurrencyType(),
            '34.76EUR',
            MoneyFormat::DECORATION_WITHOUT_SPACE,
            MoneyFormat::DECORATION_ISO_CODE,
        ];
        yield [
            '34.76',
            self::getNDecimalDigitsCurrencyType(2, '€', Currency::BEFORE_PLACEMENT),
            '€ 34.76',
            MoneyFormat::DECORATION_WITH_SPACE,
            MoneyFormat::DECORATION_SYMBOL,
        ];
        yield [
            '34.76',
            self::getNDecimalDigitsCurrencyType(2, '€', Currency::BEFORE_PLACEMENT),
            '€34.76',
            MoneyFormat::DECORATION_WITHOUT_SPACE,
            MoneyFormat::DECORATION_SYMBOL,
        ];
    }
}
