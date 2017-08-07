<?php

namespace Adsmurai\Currency\Contracts;

use Litipk\BigNumbers\Decimal;

interface MoneyFactory
{
    public function buildFromFloat(float $amount): Money;

    public function buildFromFractionalUnits(int $amount): Money;

    public function buildFromString(string $amount): Money;

    public function buildFromDecimal(Decimal $amount): Money;
}
