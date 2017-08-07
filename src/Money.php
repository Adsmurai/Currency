<?php

declare(strict_types=1);

namespace Adsmurai\Currency;

use Adsmurai\Currency\Contracts\Money as MoneyInterface;
use Adsmurai\Currency\Contracts\MoneyFormat as MoneyFormatInterface;
use Adsmurai\Currency\Contracts\Currency;
use InvalidArgumentException;
use Litipk\BigNumbers\Decimal;
use Litipk\BigNumbers\Errors\InfiniteInputError;
use Litipk\BigNumbers\Errors\NaNInputError;

final class Money implements MoneyInterface
{
    const DECIMAL_NUMBER_REGEXP = '(?P<amount> 0*(([1-9][0-9]*|[0-9])(\.[0-9]+)?))';
    const SIMPLE_CURRENCY_PATTERN = '/^'.self::DECIMAL_NUMBER_REGEXP.'$/x';
    const INNER_FRACTIONAL_DIGITS = 8;

    /** @var Decimal */
    private $amount;

    /** @var Currency */
    private $currencyType;

    /**
     * @param Decimal      $amount
     * @param Currency $currencyType
     */
    private function __construct(Decimal $amount, Currency $currencyType)
    {
        if ($amount->isNegative()) {
            throw new InvalidArgumentException('Currency amounts must be positive');
        }

        $this->amount = $amount;
        $this->currencyType = $currencyType;
    }

    public static function fromFloat(float $amount, Currency $currencyType): Money
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

    public static function fromFractionalUnits(int $amount, Currency $currencyType): Money
    {
        $decimalAmount = Decimal::fromInteger($amount)
            ->div(
                Decimal::fromInteger(10 ** $currencyType->getNumFractionalDigits()),
                self::INNER_FRACTIONAL_DIGITS
            );

        return new self($decimalAmount, $currencyType);
    }

    public static function fromString(string $amount, Currency $currencyType): Money
    {
        return new self(
            self::extractNumericAmount($amount, $currencyType),
            $currencyType
        );
    }

    private static function extractNumericAmount(string $amount, Currency $currencyType): Decimal
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

    /**
     * @param Currency $currencyType
     *
     * @return string
     */
    private static function getAmountPlusIsoCodePattern(Currency $currencyType): string
    {
        $amountPlusIsoCodePattern = '/^'.self::DECIMAL_NUMBER_REGEXP.'\s*'.$currencyType->getISOCode().'$/x';

        return $amountPlusIsoCodePattern;
    }

    private static function getAmountPlusSymbolPattern(Currency $currencyType): string
    {
        $escapedSymbol = \preg_quote($currencyType->getSymbol());

        return (Currency::BEFORE_PLACEMENT === $currencyType->getSymbolPlacement())
            ? '/^'.$escapedSymbol.'\s*'.self::DECIMAL_NUMBER_REGEXP.'$/x'
            : '/^'.self::DECIMAL_NUMBER_REGEXP.'\s*'.$escapedSymbol.'$/x';
    }

    public static function fromDecimal(Decimal $amount, Currency $currencyType): Money
    {
        return new self(
            Decimal::fromDecimal($amount, self::INNER_FRACTIONAL_DIGITS),
            $currencyType
        );
    }

    public function getCurrencyType(): Currency
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
     * {@inheritdoc}
     */
    public function format(MoneyFormatInterface $currencyFormat = null): string
    {
        if (is_null($currencyFormat)) {
            $currencyFormat = MoneyFormat::default();
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

        return $this->decorate($number, $currencyFormat);
    }

    /**
     * @param string                  $number
     * @param MoneyFormatInterface $currencyFormat
     *
     * @return string
     */
    private function decorate(string $number, MoneyFormatInterface $currencyFormat): string
    {
        $separator = (MoneyFormat::DECORATION_WITH_SPACE === $currencyFormat->getDecorationSpace())
            ? ' '
            : '';
        switch ($currencyFormat->getDecorationType()) {
            case MoneyFormat::DECORATION_NO_DECORATION:
                return $number;
                break;
            case MoneyFormat::DECORATION_ISO_CODE:
                return $number.$separator.$this->currencyType->getISOCode();
                break;
            default:
                return (Currency::BEFORE_PLACEMENT === $this->currencyType->getSymbolPlacement())
                    ? $this->currencyType->getSymbol().$separator.$number
                    : $number.$separator.$this->currencyType->getSymbol();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function equals(MoneyInterface $currency): bool
    {
        return $currency === $this || (
                $this->amount->equals($currency->getAmountAsDecimal()) &&
                $this->currencyType->equals($currency->getCurrencyType())
            );
    }
}
