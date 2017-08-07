<?php

declare(strict_types=1);

namespace Adsmurai\Currency;

use Adsmurai\Currency\Contracts\Money as MoneyInterface;
use Adsmurai\Currency\Contracts\MoneyFactory as MoneyFactoryInterface;
use Adsmurai\Currency\Contracts\Currency;
use Litipk\BigNumbers\Decimal;

final class MoneyFactory implements MoneyFactoryInterface
{
    /** @var Currency */
    private $currencyType;

    public function __construct(Currency $currencyType)
    {
        $this->currencyType = $currencyType;
    }

    public function buildFromFloat(float $amount): MoneyInterface
    {
        return Money::fromFloat($amount, $this->currencyType);
    }

    public function buildFromFractionalUnits(int $amount): MoneyInterface
    {
        return Money::fromFractionalUnits($amount, $this->currencyType);
    }

    public function buildFromString(string $amount): MoneyInterface
    {
        return Money::fromString($amount, $this->currencyType);
    }

    public function buildFromDecimal(Decimal $amount): MoneyInterface
    {
        return Money::fromDecimal($amount, $this->currencyType);
    }
}
