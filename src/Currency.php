<?php

namespace Adsmurai\Currency;

use Adsmurai\Currency\Interfaces\Currency  as CurrencyInterface;

class Currency implements CurrencyInterface
{
    /** @var int */
    private $amount;

    /** @var CurrencyType */
    private $currencyType;

    private function __construct()
    {

    }

    public static function fromFloat(): CurrencyInterface
    {

    }
}
