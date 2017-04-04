<?php

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Interfaces\Currency as CurrencyInterface;
use PHPUnit\Framework\TestCase;

class equalsTests extends TestCase
{
    /**
     * @dataProvider equalCurrenciesProvider
     */
    public function test_equality(CurrencyInterface $c1, CurrencyInterface $c2)
    {

    }

    /**
     * @dataProvider unequalCurrenciesProvider
     */
    public function test_inequality(CurrencyInterface $c1, CurrencyInterface $c2)
    {

    }

    public function equalCurrenciesProvider(): array
    {
        return [

        ];
    }

    public function unequalCurrenciesProvider(): array
    {
        return [

        ];
    }
}
