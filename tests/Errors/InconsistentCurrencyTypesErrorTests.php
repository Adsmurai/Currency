<?php

namespace Adsmurai\Currency\Tests\Errors;

use Adsmurai\Currency\CurrencyType;
use Adsmurai\Currency\Errors\InconsistentCurrencyTypesError;
use Adsmurai\Currency\Tests\CurrencyTypeTests;
use PHPUnit\Framework\TestCase;

class InconsistentCurrencyTypesErrorTests extends TestCase
{
    /**
     * @covers \Adsmurai\Currency\Errors\InconsistentCurrencyTypesError
     */
    public function test___construct_with_valid_params()
    {
        $ct1 = new CurrencyType(
            CurrencyTypeTests::EURO_ISO_CODE,
            CurrencyTypeTests::EURO_SYMBOL,
            CurrencyTypeTests::EURO_NUM_DIGITS,
            CurrencyTypeTests::EURO_SYMBOL_PLACEMENT,
            CurrencyTypeTests::EURO_NAME
        );

        $ct2 = new CurrencyType(
            CurrencyTypeTests::EURO_ISO_CODE,
            CurrencyTypeTests::EURO_SYMBOL,
            4,
            CurrencyTypeTests::EURO_SYMBOL_PLACEMENT,
            CurrencyTypeTests::EURO_NAME
        );

        $e = new InconsistentCurrencyTypesError($ct1, $ct2);

        $this->assertContains($ct1, $e->getInconsistentCurrencyTypes());
        $this->assertContains($ct2, $e->getInconsistentCurrencyTypes());
        $this->assertCount(2, $e->getInconsistentCurrencyTypes());
    }

    /**
     * @covers \Adsmurai\Currency\Errors\InconsistentCurrencyTypesError
     * @expectedException \LogicException
     * @expectedExceptionMessage Trying to construct InconsistentCurrencyTypesError with exactly equal CurrencyType instances
     */
    public function test___construct_with_invalid_params()
    {
        $ct1 = new CurrencyType(
            CurrencyTypeTests::EURO_ISO_CODE,
            CurrencyTypeTests::EURO_SYMBOL,
            CurrencyTypeTests::EURO_NUM_DIGITS,
            CurrencyTypeTests::EURO_SYMBOL_PLACEMENT,
            CurrencyTypeTests::EURO_NAME
        );

        $e = new InconsistentCurrencyTypesError($ct1, $ct1);
    }
}