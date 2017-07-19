<?php

namespace Adsmurai\Currency;

use Adsmurai\Currency\Contracts\CurrencyFormat as CurrencyFormatInterface;

class CurrencyFormat implements CurrencyFormatInterface
{
    /**
     * @var string
     */
    private $decimalsSeparator;
    /**
     * @var string
     */
    private $thousandsSeparator;
    /**
     * @var int
     */
    private $extraPrecision;

    public function __construct(string $decimalsSeparator = '.', string $thousandsSeparator = '', int $extraPrecision = 0)
    {
        $this->decimalsSeparator = $decimalsSeparator;
        $this->thousandsSeparator = $thousandsSeparator;
        $this->extraPrecision = $extraPrecision;
    }

    /**
     * @return string
     */
    public function getDecimalsSeparator(): string
    {
        return $this->decimalsSeparator;
    }

    /**
     * @return string
     */
    public function getThousandsSeparator(): string
    {
        return $this->thousandsSeparator;
    }

    /**
     * @return int
     */
    public function getExtraPrecision(): int
    {
        return $this->extraPrecision;
    }
}
