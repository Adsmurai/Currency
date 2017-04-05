<?php
declare(strict_types=1);

namespace Adsmurai\Currency;

use Adsmurai\Currency\Interfaces\Currency as CurrencyInterface;
use Adsmurai\Currency\Interfaces\CurrencyFactory as CurrencyFactoryInterface;
use Adsmurai\Currency\Interfaces\CurrencyType;
use Litipk\BigNumbers\Decimal;

class CurrencyFactory implements CurrencyFactoryInterface
{
    /** @var CurrencyType */
    private $currencyType;

    public function __construct(CurrencyType $currencyType)
    {
        $this->currencyType = $currencyType;
    }

    public function buildFromFloat(float $amount): CurrencyInterface
    {
        return Currency::fromFloat($amount, $this->currencyType);
    }

    public function buildFromFractionalUnits(int $amount): CurrencyInterface
    {
        return Currency::fromFractionalUnits($amount, $this->currencyType);
    }

    public function buildFromString(string $amount): CurrencyInterface
    {
        return Currency::fromString($amount, $this->currencyType);
    }

    public function buildFromDecimal(Decimal $amount): CurrencyInterface
    {
        return Currency::fromDecimal($amount, $this->currencyType);
    }
}
