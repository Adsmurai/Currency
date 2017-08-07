<?php

declare(strict_types=1);

namespace Adsmurai\Currency;

use Adsmurai\Currency\Contracts\Money as CurrencyInterface;
use Adsmurai\Currency\Contracts\MoneyFactory as CurrencyFactoryInterface;
use Adsmurai\Currency\Contracts\Currency;
use Litipk\BigNumbers\Decimal;

final class MoneyFactory implements CurrencyFactoryInterface
{
    /** @var Currency */
    private $currencyType;

    public function __construct(Currency $currencyType)
    {
        $this->currencyType = $currencyType;
    }

    public function buildFromFloat(float $amount): CurrencyInterface
    {
        return Money::fromFloat($amount, $this->currencyType);
    }

    public function buildFromFractionalUnits(int $amount): CurrencyInterface
    {
        return Money::fromFractionalUnits($amount, $this->currencyType);
    }

    public function buildFromString(string $amount): CurrencyInterface
    {
        return Money::fromString($amount, $this->currencyType);
    }

    public function buildFromDecimal(Decimal $amount): CurrencyInterface
    {
        return Money::fromDecimal($amount, $this->currencyType);
    }
}
