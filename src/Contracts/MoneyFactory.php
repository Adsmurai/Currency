<?php

namespace Adsmurai\Currency\Contracts;

use Brick\Math\BigDecimal;

interface MoneyFactory
{
    public function buildFromFloat(float $amount): Money;

    public function buildFromFractionalUnits(int $amount): Money;

    public function buildFromString(string $amount): Money;

    public function buildFromDecimal(BigDecimal $amount): Money;
}
