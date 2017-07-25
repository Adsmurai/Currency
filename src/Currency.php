<?php

declare(strict_types=1);

namespace Adsmurai\Currency;

use Adsmurai\Currency\Contracts\Currency  as CurrencyInterface;
use Adsmurai\Currency\Contracts\CurrencyFormat as CurrencyFormatInterface;
use Adsmurai\Currency\Contracts\CurrencyType;
use InvalidArgumentException;
use Litipk\BigNumbers\Decimal;
use Litipk\BigNumbers\Errors\InfiniteInputError;
use Litipk\BigNumbers\Errors\NaNInputError;

final class Currency implements CurrencyInterface
{
    const DECIMAL_NUMBER_REGEXP = '(?P<amount> 0*(([1-9][0-9]*|[0-9])(\.[0-9]+)?))';
    const SIMPLE_CURRENCY_PATTERN = '/^'.self::DECIMAL_NUMBER_REGEXP.'$/x';

    const INNER_FRACTIONAL_DIGITS = 8;

    /** @var Decimal */
    private $amount;

    /** @var CurrencyType */
    private $currencyType;

    /**
     * @param Decimal      $amount
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
        $decimalAmount = Decimal::fromInteger($amount)
            ->div(
                Decimal::fromInteger(10 ** $currencyType->getNumFractionalDigits()),
                self::INNER_FRACTIONAL_DIGITS
            );

        return new self($decimalAmount, $currencyType);
    }

    public static function fromString(string $amount, CurrencyType $currencyType): Currency
    {
        return new self(
            self::extractNumericAmount($amount, $currencyType),
            $currencyType
        );
    }

    private static function extractNumericAmount(string $amount, CurrencyType $currencyType): Decimal
    {
        try {
            if (
                1 === \preg_match(self::SIMPLE_CURRENCY_PATTERN, $amount, $matches) ||
                1 === \preg_match(self::getAmountPlusIsoCodePattern($currencyType), $amount, $matches) ||
                1 === \preg_match(self::getAmountPlusSymbolPattern($currencyType), $amount, $matches)
            ) {
                return Decimal::fromString($matches['amount'], self::INNER_FRACTIONAL_DIGITS);
            } else {
                throw new InvalidArgumentException('Invalid currency value');
            }
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

    private static function getAmountPlusSymbolPattern(CurrencyType $currencyType): string
    {
        $escapedSymbol = \preg_quote($currencyType->getSymbol());

        return ($currencyType->getSymbolPlacement() === CurrencyType::BEFORE_PLACEMENT)
            ? '/^'.$escapedSymbol.'\s*'.self::DECIMAL_NUMBER_REGEXP.'$/x'
            : '/^'.self::DECIMAL_NUMBER_REGEXP.'\s*'.$escapedSymbol.'$/x';
    }

    /**
     * @param CurrencyType $currencyType
     *
     * @return string
     */
    private static function getAmountPlusIsoCodePattern(CurrencyType $currencyType): string
    {
        $amountPlusIsoCodePattern = '/^'.self::DECIMAL_NUMBER_REGEXP.'\s*'.$currencyType->getISOCode().'$/x';

        return $amountPlusIsoCodePattern;
    }

    public function getCurrencyType(): CurrencyType
    {
        return $this->currencyType;
    }

    /**
     * {@inheritdoc}
     */
    public function getAmountAsDecimal(): Decimal
    {
        return $this->amount;
    }

    /**
     * {@inheritdoc}
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
     * @todo Use method getDecorationType() when decorating the result
     * {@inheritdoc}
     */
    public function format(CurrencyFormatInterface $currencyFormat = null): string
    {
        if (is_null($currencyFormat)) {
            $currencyFormat = new CurrencyFormat();
        }

        $nDecimals = $currencyFormat->getPrecision();
        if (is_null($nDecimals)) {
            $nDecimals = $this->currencyType->getNumFractionalDigits() + $currencyFormat->getExtraPrecision();
        }

        $amount = Decimal::fromDecimal($this->amount, $nDecimals);

        $number = ('' === $currencyFormat->getThousandsSeparator())
            ? \str_replace('.', $currencyFormat->getDecimalsSeparator(), $amount->__toString())  // This is safer!
            : \number_format(
                $amount->asFloat(),
                $nDecimals,
                $currencyFormat->getDecimalsSeparator(),
                $currencyFormat->getThousandsSeparator()
            );

        return ($this->currencyType->getSymbolPlacement() === CurrencyType::BEFORE_PLACEMENT)
            ? $this->currencyType->getSymbol().$number
            : $number.$this->currencyType->getSymbol();
    }

    /**
     * {@inheritdoc}
     */
    public function equals(CurrencyInterface $currency): bool
    {
        return $currency === $this || (
            $this->amount->equals($currency->getAmountAsDecimal()) &&
            $this->currencyType->equals($currency->getCurrencyType())
        );
    }
}
