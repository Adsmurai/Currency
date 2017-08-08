<?php

declare(strict_types=1);

namespace Adsmurai\Currency;

use Adsmurai\Currency\Contracts\Money as MoneyContract;
use Adsmurai\Currency\Contracts\MoneyFactory as MoneyFactoryContract;
use Adsmurai\Currency\Contracts\Currency as CurrencyContract;
use Litipk\BigNumbers\Decimal;

final class MoneyFactory implements MoneyFactoryContract
{
    /** @var Currency */
    private $currency;

    public function __construct(CurrencyContract $currency)
    {
        $this->currency = $currency;
    }

    public function buildFromFloat(float $amount): MoneyContract
    {
        return Money::fromFloat($amount, $this->currency);
    }

    public function buildFromFractionalUnits(int $amount): MoneyContract
    {
        return Money::fromFractionalUnits($amount, $this->currency);
    }

    public function buildFromString(string $amount): MoneyContract
    {
        return Money::fromString($amount, $this->currency);
    }

    public function buildFromDecimal(Decimal $amount): MoneyContract
    {
        return Money::fromDecimal($amount, $this->currency);
    }
}
