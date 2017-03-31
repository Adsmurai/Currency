<?php

namespace Adsmurai\Currency\Tests\Errors;

use Adsmurai\Currency\Errors\InconsistentCurrencyTypesError;
use Adsmurai\Currency\Interfaces\CurrencyType;

use Mockery;
use PHPUnit\Framework\TestCase;

class InconsistentCurrencyTypesErrorTests extends TestCase
{
    /**
     * @covers \Adsmurai\Currency\Errors\InconsistentCurrencyTypesError
     */
    public function test___construct_with_valid_params()
    {
        /** @var CurrencyType $ct1 */
        $ct1 = Mockery::mock(CurrencyType::class);
        /** @var CurrencyType $ct2 */
        $ct2 = Mockery::mock(CurrencyType::class);

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
        /** @var CurrencyType $ct1 */
        $ct1 = Mockery::mock(CurrencyType::class);

        $e = new InconsistentCurrencyTypesError($ct1, $ct1);
    }
}