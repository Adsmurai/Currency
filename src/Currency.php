<?php

namespace Adsmurai\Currency;

use Adsmurai\Currency\Interfaces\Currency  as CurrencyInterface;
use Adsmurai\Currency\Interfaces\CurrencyType;
use InvalidArgumentException;

final class Currency implements CurrencyInterface
{
    const INNER_FRACTIONAL_DIGITS = 8;

    const FLOAT_MULTIPLIER = 10 ** self::INNER_FRACTIONAL_DIGITS;

    /**
     * Represented as a number of fractional units (1/10⁸)
     * @var int
     */
    private $amount;

    /** @var CurrencyType */
    private $currencyType;

    /**
     * @param int $amount Measured in number of fractional units (1/10⁸)
     * @param CurrencyType $currencyType
     */
    private function __construct(int $amount, CurrencyType $currencyType)
    {
        if (0 > $amount) {
            throw new InvalidArgumentException('Currency amounts must be positive');
        }

        $this->amount = $amount;
        $this->currencyType = $currencyType;
    }

    public static function fromFloat(float $amount, CurrencyType $currencyType): Currency
    {
        if (\is_infinite($amount)) {
            throw new InvalidArgumentException('Currency amounts must be finite');
        } elseif (\is_nan($amount)) {
            throw new InvalidArgumentException('Currency amounts must be numbers');
        }

        return new self(
            (int)\round($amount * self::FLOAT_MULTIPLIER),
            $currencyType
        );
    }

    public static function fromFractionalUnits(int $amount, CurrencyType $currencyType): Currency
    {
        $multiplier = (int)\pow(
            10,
            self::INNER_FRACTIONAL_DIGITS - $currencyType->getNumFractionalDigits()
        );

        return new self(
            (int)\round($amount * $multiplier),
            $currencyType
        );
    }

    public function getCurrencyType(): CurrencyType
    {
        // TODO: Implement getCurrencyType() method.
    }

    /**
     * WARNING: This method is not meant to be used in currency formatting code nor currency representation code.
     *
     * This method returns the monetary amount as a string representing a decimal number. Its meant to be used in
     * fixed precision mathematical operations, like the ones that can be done with libraries like BCMath.
     *
     * @return string
     */
    public function getAmountAsString(): string
    {
        // TODO: Implement getAmountAsString() method.
    }

    /**
     * WARNING: This method is not meant to be used in currency formatting code nor currency representation code.
     *
     * Every currency has a minimum fractional unit that can be used for commercial transactions. Examples:
     *  - euros (EUR)           1/100   = 0.01
     *  - bahraini dinars (BHD) 1/1000  = 0.001.
     *
     * This method returns the monetary amount measured in currency's minimum fractional units. Examples:
     *  - 171.43 €   ->  17143
     *  - 56.611 BD  ->  56611
     *
     * @return int
     */
    public function getAmountAsFractionalUnits(): int
    {
        // TODO: Implement getAmountAsFractionalUnits() method.
    }

    /**
     * Use this method to represent monetary amounts as strings.
     *
     * @param string $decimalsSeparator
     * @param string $thousandsSeparator
     * @return string
     */
    public function format(string $decimalsSeparator = '.', $thousandsSeparator = ''): string
    {
        // TODO: Implement format() method.
    }

    /**
     * Use this method to compare currency values.
     * It will return false if the amount or the currency types don't match.
     *
     * @param CurrencyInterface $currency
     * @return bool
     */
    public function equals(CurrencyInterface $currency): bool
    {
        // TODO: Implement equals() method.
    }
}
