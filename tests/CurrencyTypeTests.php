<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests;

use Adsmurai\Currency\Contracts\Currency as CurrencyTypeInterface;
use Adsmurai\Currency\Currency;
use PHPUnit\Framework\TestCase;

class CurrencyTypeTests extends TestCase
{
    public const EURO_ISO_CODE = 'EUR';
    public const EURO_NAME = 'euro';
    public const EURO_SYMBOL = '€';
    public const EURO_NUM_DIGITS = 2;
    public const EURO_SYMBOL_PLACEMENT = CurrencyTypeInterface::AFTER_PLACEMENT;

    public const USD_ISO_CODE = 'USD';
    public const USD_NAME = 'dollar';
    public const USD_SYMBOL = '$';
    public const USD_NUM_DIGITS = 2;
    public const USD_SYMBOL_PLACEMENT = CurrencyTypeInterface::BEFORE_PLACEMENT;

    public function test___construct_with_valid_params(): void
    {
        $currencyType = $this->getEuroCurrencyType();

        $this->assertInstanceOf(CurrencyTypeInterface::class, $currencyType);

        $this->assertSame(self::EURO_ISO_CODE, $currencyType->getISOCode());
        $this->assertSame(self::EURO_SYMBOL, $currencyType->getSymbol());
        $this->assertSame(self::EURO_NAME, $currencyType->getName());
        $this->assertSame(self::EURO_NUM_DIGITS, $currencyType->getNumFractionalDigits());
        $this->assertSame(self::EURO_SYMBOL_PLACEMENT, $currencyType->getSymbolPlacement());
    }

    private function getEuroCurrencyType(): Currency
    {
        return new Currency(
            self::EURO_ISO_CODE,
            self::EURO_SYMBOL,
            self::EURO_NUM_DIGITS,
            self::EURO_SYMBOL_PLACEMENT,
            self::EURO_NAME
        );
    }

    /**
     * @covers \Adsmurai\Currency\Currency::__construct
     */
    public function test__construct_with_negative_num_of_fractional_digits(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid number of fractional digits');

        new Currency(
            self::EURO_ISO_CODE,
            '',
            -1,
            self::EURO_SYMBOL_PLACEMENT,
            self::EURO_NAME
        );
    }

    /**
     * @covers \Adsmurai\Currency\Currency::__construct
     */
    public function test__construct_with_invalid_symbol_placement(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid symbol placement');

        new Currency(
            self::EURO_ISO_CODE,
            '',
            self::EURO_NUM_DIGITS,
            23,
            self::EURO_NAME
        );
    }

    /**
     * @covers \Adsmurai\Currency\Currency::__construct
     */
    public function test__construct_with_empty_symbol(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Empty symbol');

        new Currency(
            self::EURO_ISO_CODE,
            '',
            self::EURO_NUM_DIGITS,
            self::EURO_SYMBOL_PLACEMENT,
            self::EURO_NAME
        );
    }

    /**
     * @covers \Adsmurai\Currency\Currency::__construct
     */
    public function test__construct_with_almost_empty_symbol(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Empty symbol');

        new Currency(
            self::EURO_ISO_CODE,
            '    ',
            self::EURO_NUM_DIGITS,
            self::EURO_SYMBOL_PLACEMENT,
            self::EURO_NAME
        );
    }

    /**
     * @covers \Adsmurai\Currency\Currency::equals
     */
    public function test_equals_with_equal_CurrencyType_instances(): void
    {
        $ct1 = $this->getEuroCurrencyType();
        $ct2 = $this->getEuroCurrencyType();

        $this->assertTrue($ct1->equals($ct2));
        $this->assertTrue($ct2->equals($ct1));
    }

    /**
     * @covers \Adsmurai\Currency\Currency::equals
     */
    public function test_equals_with_same_CurrencyType_instances(): void
    {
        $ct1 = $this->getEuroCurrencyType();

        $this->assertTrue($ct1->equals($ct1));
    }

    /**
     * @covers \Adsmurai\Currency\Currency::equals
     */
    public function test_equals_with_different_CurrencyType_instances(): void
    {
        $ct1 = $this->getEuroCurrencyType();

        $ct2 = new Currency(
            self::USD_ISO_CODE,
            self::USD_SYMBOL,
            self::USD_NUM_DIGITS,
            self::USD_SYMBOL_PLACEMENT,
            self::USD_NAME
        );

        $this->assertFalse($ct1->equals($ct2));
        $this->assertFalse($ct2->equals($ct1));
    }

    /**
     * @covers \Adsmurai\Currency\Currency::equals
     */
    public function test_equals_with_ambiguously_similar_CurrencyType_instances(): void
    {
        $ct1 = $this->getEuroCurrencyType();

        $ct2 = new Currency(
            self::EURO_ISO_CODE,
            self::EURO_SYMBOL,
            4,
            self::EURO_SYMBOL_PLACEMENT,
            self::EURO_NAME
        );

        $this->expectException(\Adsmurai\Currency\Errors\InconsistentCurrenciesError::class);
        $this->expectExceptionMessage('Same ISO currency code but different currency settings');

        $ct1->equals($ct2);
    }
}
