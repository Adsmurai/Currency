<?php

namespace Adsmurai\Currency\Interfaces;

use Litipk\BigNumbers\Decimal;

interface CurrencyFactory
{
    public function buildFromFloat(float $amount): Currency;

    public function buildFromFractionalUnits(int $amount): Currency;

    public function buildFromString(string $amount): Currency;

    public function buildFromDecimal(Decimal $amount): Currency;
}
