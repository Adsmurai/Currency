<?php

namespace Adsmurai\Currency\Tests\Errors;

use Adsmurai\Currency\Contracts\Currency;
use Adsmurai\Currency\Errors\InconsistentCurrenciesError;
use Mockery;
use PHPUnit\Framework\TestCase;

class InconsistentCurrencyTypesErrorTests extends TestCase
{
    /**
     * @covers \Adsmurai\Currency\Errors\InconsistentCurrenciesError
     */
    public function test___construct_with_valid_params()
    {
        /** @var Currency $ct1 */
        $ct1 = Mockery::mock(Currency::class);
        /** @var Currency $ct2 */
        $ct2 = Mockery::mock(Currency::class);

        $e = new InconsistentCurrenciesError($ct1, $ct2);

        $this->assertContains($ct1, $e->getInconsistentCurrencyTypes());
        $this->assertContains($ct2, $e->getInconsistentCurrencyTypes());
        $this->assertCount(2, $e->getInconsistentCurrencyTypes());
    }

    /**
     * @covers \Adsmurai\Currency\Errors\InconsistentCurrenciesError
     */
    public function test___construct_with_invalid_params()
    {
        /** @var Currency $ct1 */
        $ct1 = Mockery::mock(Currency::class);

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Trying to construct InconsistentCurrencyTypesError with exactly equal CurrencyType instances');

        new InconsistentCurrenciesError($ct1, $ct1);
    }
}
