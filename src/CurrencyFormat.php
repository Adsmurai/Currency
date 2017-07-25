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
    /**
     * @var int
     */
    private $decorationType;
    /**
     * @var int
     */
    private $precision;

    public function __construct(
        string $decimalsSeparator = '.',
        string $thousandsSeparator = '',
        int $extraPrecision = 0,
        int $decorationType = self::DECORATION_NO_DECORATION,
        int $precision = null
    ) {
        $this->decimalsSeparator = $decimalsSeparator;
        $this->thousandsSeparator = $thousandsSeparator;
        $this->extraPrecision = $extraPrecision;
        $this->decorationType = $decorationType;
        $this->precision = $precision;
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

    /**
     * @return int
     */
    public function getDecorationType(): int
    {
        return $this->decorationType;
    }

    /**
     * @return int|null
     */
    public function getPrecision()
    {
        return $this->precision;
    }
}
