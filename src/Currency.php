<?php
declare(strict_types=1);

namespace Adsmurai\Currency;

use Adsmurai\Currency\Interfaces\Currency  as CurrencyInterface;
use Adsmurai\Currency\Interfaces\CurrencyType;
use InvalidArgumentException;
use Litipk\BigNumbers\Decimal;
use Litipk\BigNumbers\Errors\InfiniteInputError;
use Litipk\BigNumbers\Errors\NaNInputError;

final class Currency implements CurrencyInterface
{
    const INNER_FRACTIONAL_DIGITS = 8;

    /**
     * @var Decimal
     */
    private $amount;

    /** @var CurrencyType */
    private $currencyType;

    /**
     * @param Decimal $amount
     * @param CurrencyType $currencyType
     */
    private function __construct(Decimal $amount, CurrencyType $currencyType)
    {
        if ($amount->isNegative()) {
            throw new InvalidArgumentException('Currency amounts must be positive');
        }

        $this->amount = $amount;
        $this->currencyType = $currencyType;
    }

    public static function fromFloat(float $amount, CurrencyType $currencyType): Currency
    {
        try {
            return new self(
                Decimal::fromFloat($amount, self::INNER_FRACTIONAL_DIGITS),
                $currencyType
            );
        } catch (InfiniteInputError $e) {
            throw new InvalidArgumentException('Currency amounts must be finite', 0, $e);
        } catch (NaNInputError $e) {
            throw new InvalidArgumentException('Currency amounts must be numbers', 0, $e);
        }
    }

    public static function fromFractionalUnits(int $amount, CurrencyType $currencyType): Currency
    {
        return new self(
            Decimal::fromInteger($amount)
                ->div(
                    Decimal::fromInteger(10 ** $currencyType->getNumFractionalDigits()),
                    self::INNER_FRACTIONAL_DIGITS
                ),
            $currencyType
        );
    }

    public static function fromString(string $amount, CurrencyType $currencyType): Currency
    {
        try {
            return new self(
                Decimal::fromString($amount, self::INNER_FRACTIONAL_DIGITS),
                $currencyType
            );
        } catch (NaNInputError $e) {
            throw new InvalidArgumentException('Currency amounts must be numbers', 0, $e);
        }
    }

    public static function fromDecimal(Decimal $amount, CurrencyType $currencyType): Currency
    {
        return new self(
            Decimal::fromDecimal($amount, self::INNER_FRACTIONAL_DIGITS),
            $currencyType
        );
    }

    public function getCurrencyType(): CurrencyType
    {
        return $this->currencyType;
    }

    /**
     * @inheritdoc
     */
    public function getAmountAsDecimal(): Decimal
    {
        return $this->amount;
    }

    /**
     * @inheritdoc
     */
    public function getAmountAsFractionalUnits(): int
    {
        return $this->amount
            ->mul(
                Decimal::fromInteger(10 ** $this->currencyType->getNumFractionalDigits()),
                self::INNER_FRACTIONAL_DIGITS
            )
            ->asInteger();
    }

    /**
     * @inheritdoc
     */
    public function format(string $decimalsSeparator='.', $thousandsSeparator='', int $extraPrecision=0): string
    {
        $nDecimals = $this->currencyType->getNumFractionalDigits() + $extraPrecision;
        $amount = Decimal::fromDecimal($this->amount, $nDecimals);

        $number = ('' === $thousandsSeparator)
            ? \str_replace('.', $decimalsSeparator, $amount->__toString())  // This is safer!
            : \number_format($amount->asFloat(), $nDecimals, $decimalsSeparator, $thousandsSeparator);

        return ($this->currencyType->getSymbolPlacement() === CurrencyType::BEFORE_PLACEMENT)
            ? $this->currencyType->getSymbol() . $number
            : $number . $this->currencyType->getSymbol();
    }

    /**
     * @inheritdoc
     */
    public function equals(CurrencyInterface $currency): bool
    {
        return $currency === $this || (
            $this->amount->equals($currency->getAmountAsDecimal()) &&
            $this->currencyType->equals($currency->getCurrencyType())
        );
    }
}
