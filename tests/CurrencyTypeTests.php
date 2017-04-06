<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests;

use Adsmurai\Currency\CurrencyType;
use Adsmurai\Currency\Contracts\CurrencyType as CurrencyTypeInterface;
use PHPUnit\Framework\TestCase;

class CurrencyTypeTests extends TestCase
{
    const EURO_ISO_CODE = 'EUR';
    const EURO_NAME = 'euro';
    const EURO_SYMBOL = '€';
    const EURO_NUM_DIGITS = 2;
    const EURO_SYMBOL_PLACEMENT = CurrencyTypeInterface::AFTER_PLACEMENT;

    const USD_ISO_CODE = 'USD';
    const USD_NAME = 'dollar';
    const USD_SYMBOL = '$';
    const USD_NUM_DIGITS = 2;
    const USD_SYMBOL_PLACEMENT = CurrencyTypeInterface::BEFORE_PLACEMENT;

    public function test___construct_with_valid_params()
    {
        $currencyType = self::getEuroCurrencyType();

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
        new CurrencyType(
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
        new CurrencyType(
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
        new CurrencyType(
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
        new CurrencyType(
            self::EURO_ISO_CODE,
            '    ',
            self::EURO_NUM_DIGITS,
            self::EURO_SYMBOL_PLACEMENT,
            self::EURO_NAME
        );
    }

    /**
     * @covers \Adsmurai\Currency\CurrencyType::equals
     */
    public function test_equals_with_equal_CurrencyType_instances()
    {
        $ct1 = self::getEuroCurrencyType();
        $ct2 = self::getEuroCurrencyType();

        $this->assertTrue($ct1->equals($ct2));
        $this->assertTrue($ct2->equals($ct1));
    }

    /**
     * @covers \Adsmurai\Currency\CurrencyType::equals
     */
    public function test_equals_with_same_CurrencyType_instances()
    {
        $ct1 = self::getEuroCurrencyType();

        $this->assertTrue($ct1->equals($ct1));
    }

    /**
     * @covers \Adsmurai\Currency\CurrencyType::equals
     */
    public function test_equals_with_different_CurrencyType_instances()
    {
        $ct1 = self::getEuroCurrencyType();

        $ct2 = new CurrencyType(
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
     * @covers \Adsmurai\Currency\CurrencyType::equals
     * @expectedException \Adsmurai\Currency\Errors\InconsistentCurrencyTypesError
     * @expectedExceptionMessage Same ISO currency code but different currency settings
     */
    public function test_equals_with_ambiguously_similar_CurrencyType_instances()
    {
        $ct1 = self::getEuroCurrencyType();

        $ct2 = new CurrencyType(
            self::EURO_ISO_CODE,
            self::EURO_SYMBOL,
            4,
            self::EURO_SYMBOL_PLACEMENT,
            self::EURO_NAME
        );

        $ct1->equals($ct2);
    }

    private static function getEuroCurrencyType(): CurrencyType
    {
        return new CurrencyType(
            self::EURO_ISO_CODE,
            self::EURO_SYMBOL,
            self::EURO_NUM_DIGITS,
            self::EURO_SYMBOL_PLACEMENT,
            self::EURO_NAME
        );
    }
}
