<?php

namespace Adsmurai\Currency\Tests;

use Adsmurai\Currency\CurrencyType;
use Adsmurai\Currency\Interfaces\CurrencyType as CurrencyTypeInterface;
use PHPUnit\Framework\TestCase;

class CurrencyTypeTests extends TestCase
{
    const EURO_ISO_CODE = 'EUR';
    const EURO_NAME = 'euro';
    const EURO_SYMBOL = '€';
    const EURO_NUM_DIGITS = 2;
    const EURO_SYMBOL_PLACEMENT = CurrencyTypeInterface::AFTER_PLACEMENT;

    public function test___construct_with_valid_params()
    {
        $currencyType = new CurrencyType(
            self::EURO_ISO_CODE,
            self::EURO_SYMBOL,
            self::EURO_NUM_DIGITS,
            self::EURO_SYMBOL_PLACEMENT,
            self::EURO_NAME
        );

        $this->assertInstanceOf(CurrencyTypeInterface::class, $currencyType);

        $this->assertEquals(self::EURO_ISO_CODE, $currencyType->getISOCode());
        $this->assertEquals(self::EURO_SYMBOL, $currencyType->getSymbol());
        $this->assertEquals(self::EURO_NAME, $currencyType->getName());
        $this->assertEquals(self::EURO_NUM_DIGITS, $currencyType->getNumFractionalDigits());
        $this->assertEquals(self::EURO_SYMBOL_PLACEMENT, $currencyType->getSymbolPlacement());
    }

    /**
     * @covers \Adsmurai\Currency\CurrencyType::__construct
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid number of fractional digits
     */
    public function test__construct_with_negative_num_of_fractional_digits()
    {
        $currencyType = new CurrencyType(
            self::EURO_ISO_CODE,
            '',
            -1,
            self::EURO_SYMBOL_PLACEMENT,
            self::EURO_NAME
        );
    }

    /**
     * @covers \Adsmurai\Currency\CurrencyType::__construct
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid symbol placement
     */
    public function test__construct_with_invalid_symbol_placement()
    {
        $currencyType = new CurrencyType(
            self::EURO_ISO_CODE,
            '',
            self::EURO_NUM_DIGITS,
            23,
            self::EURO_NAME
        );
    }

    /**
     * @covers \Adsmurai\Currency\CurrencyType::__construct
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Empty symbol
     */
    public function test__construct_with_empty_symbol()
    {
        $currencyType = new CurrencyType(
            self::EURO_ISO_CODE,
            '',
            self::EURO_NUM_DIGITS,
            self::EURO_SYMBOL_PLACEMENT,
            self::EURO_NAME
        );
    }

    /**
     * @covers \Adsmurai\Currency\CurrencyType::__construct
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Empty symbol
     */
    public function test__construct_with_almost_empty_symbol()
    {
        $currencyType = new CurrencyType(
            self::EURO_ISO_CODE,
            '    ',
            self::EURO_NUM_DIGITS,
            self::EURO_SYMBOL_PLACEMENT,
            self::EURO_NAME
        );
    }
}
