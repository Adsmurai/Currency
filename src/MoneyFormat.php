<?php

namespace Adsmurai\Currency;

use Adsmurai\Currency\Contracts\MoneyFormat as MoneyFormatInterface;

final class MoneyFormat implements MoneyFormatInterface
{
    private function __construct(
        private readonly string $decimalsSeparator = self::DEFAULT_DECIMALS_SEPARATOR,
        private readonly string $thousandsSeparator = self::DEFAULT_THOUSANDS_SEPARATOR,
        private readonly int $decorationType = self::DECORATION_SYMBOL,
        private readonly int $decorationSpace = self::DECORATION_WITHOUT_SPACE,
        private readonly int $extraPrecision = 0,
        /**
         * @var int
         */
        private readonly ?int $precision = null
    )
    {
    }

    public static function default(): MoneyFormatInterface
    {
        return new self();
    }

    public static function fromParameters(
        string $decimalsSeparator = self::DEFAULT_DECIMALS_SEPARATOR,
        string $thousandsSeparator = self::DEFAULT_THOUSANDS_SEPARATOR,
        int $decorationType = self::DECORATION_SYMBOL,
        int $decorationSpace = self::DECORATION_WITHOUT_SPACE
    ): MoneyFormatInterface {
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
    ): MoneyFormatInterface {
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
    ): MoneyFormatInterface {
        return new self(
            $decimalsSeparator,
            $thousandsSeparator,
            $decorationType,
            $decorationSpace,
            $extraPrecision
        );
    }

    public function getDecimalsSeparator(): string
    {
        return $this->decimalsSeparator;
    }

    public function getThousandsSeparator(): string
    {
        return $this->thousandsSeparator;
    }

    public function getExtraPrecision(): int
    {
        return $this->extraPrecision;
    }

    public function getDecorationType(): int
    {
        return $this->decorationType;
    }

    public function getPrecision(): ?int
    {
        return $this->precision;
    }

    public function getDecorationSpace(): int
    {
        return $this->decorationSpace;
    }
}
