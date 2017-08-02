<?php

namespace Adsmurai\Currency;

use Adsmurai\Currency\Contracts\CurrencyFormat as CurrencyFormatInterface;

final class CurrencyFormat implements CurrencyFormatInterface
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
    /**
     * @var int
     */
    private $decorationSpace;

    private function __construct(
        string $decimalsSeparator = self::DEFAULT_DECIMALS_SEPARATOR,
        string $thousandsSeparator = self::DEFAULT_THOUSANDS_SEPARATOR,
        int $decorationType = self::DECORATION_SYMBOL,
        int $decorationSpace = self::DECORATION_WITHOUT_SPACE,
        int $extraPrecision = 0,
        int $precision = null
    ) {
        $this->decimalsSeparator = $decimalsSeparator;
        $this->thousandsSeparator = $thousandsSeparator;
        $this->extraPrecision = $extraPrecision;
        $this->decorationType = $decorationType;
        $this->precision = $precision;
        $this->decorationSpace = $decorationSpace;
    }

    public static function default(): CurrencyFormatInterface
    {
        return new self();
    }

    public static function fromParameters(
        string $decimalsSeparator = self::DEFAULT_DECIMALS_SEPARATOR,
        string $thousandsSeparator = self::DEFAULT_THOUSANDS_SEPARATOR,
        int $decorationType = self::DECORATION_SYMBOL,
        int $decorationSpace = self::DECORATION_WITHOUT_SPACE
    ): CurrencyFormatInterface {
        return new self(
            $decimalsSeparator,
            $thousandsSeparator,
            $decorationType,
            $decorationSpace
        );
    }

    public static function fromParametersWithPrecision(
        int $precision,
        string $decimalsSeparator = self::DEFAULT_DECIMALS_SEPARATOR,
        string $thousandsSeparator = self::DEFAULT_THOUSANDS_SEPARATOR,
        int $decorationType = self::DECORATION_SYMBOL,
        int $decorationSpace = self::DECORATION_WITHOUT_SPACE
    ): CurrencyFormatInterface {
        return new self(
            $decimalsSeparator,
            $thousandsSeparator,
            $decorationType,
            $decorationSpace,
            0,
            $precision
        );
    }

    public static function fromParametersWithExtraPrecision(
        int $extraPrecision,
        string $decimalsSeparator = self::DEFAULT_DECIMALS_SEPARATOR,
        string $thousandsSeparator = self::DEFAULT_THOUSANDS_SEPARATOR,
        int $decorationType = self::DECORATION_SYMBOL,
        int $decorationSpace = self::DECORATION_WITHOUT_SPACE
    ): CurrencyFormatInterface {
        return new self(
            $decimalsSeparator,
            $thousandsSeparator,
            $decorationType,
            $decorationSpace,
            $extraPrecision
        );
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

    public function getDecorationSpace(): int
    {
        return $this->decorationSpace;
    }
}
