<?php

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

    const FLOAT_MULTIPLIER = 10 ** self::INNER_FRACTIONAL_DIGITS;

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
        return new self(
            Decimal::fromString($amount, self::INNER_FRACTIONAL_DIGITS),
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
    public function getAmountAsString(): string
    {
        // TODO: Implement getAmountAsString() method.
    }

    /**
     * @inheritdoc
     */
    public function getAmountAsFractionalUnits(): int
    {
        // TODO: Implement getAmountAsFractionalUnits() method.
    }

    /**
     * @inheritdoc
     */
    public function format(string $decimalsSeparator='.', $thousandsSeparator='', int $extraPrecision=0): string
    {
        // TODO: Implement format() method.
    }

    /**
     * @inheritdoc
     */
    public function equals(CurrencyInterface $currency): bool
    {
        // TODO: Implement equals() method.
    }
}
