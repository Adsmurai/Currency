<?php

declare(strict_types=1);

namespace Adsmurai\Currency;

use Adsmurai\Currency\Contracts\Money as MoneyContract;
use Adsmurai\Currency\Contracts\MoneyFormat as MoneyFormatInterface;
use Adsmurai\Currency\Contracts\Currency as CurrencyContract;
use InvalidArgumentException;
use Litipk\BigNumbers\Decimal;
use Litipk\BigNumbers\Errors\InfiniteInputError;
use Litipk\BigNumbers\Errors\NaNInputError;

final class Money implements MoneyContract
{
    const DECIMAL_NUMBER_REGEXP = '(?P<amount> 0*(([1-9][0-9]*|[0-9])(\.[0-9]+)?))';
    const SIMPLE_CURRENCY_PATTERN = '/^'.self::DECIMAL_NUMBER_REGEXP.'$/x';
    const INNER_FRACTIONAL_DIGITS = 8;

    /**
     * @param Decimal          $amount
     * @param CurrencyContract $currency
     */
    private function __construct(private readonly Decimal $amount, private readonly CurrencyContract $currency)
    {
    }

    public static function fromFloat(float $amount, CurrencyContract $currency): Money
    {
        try {
            return new self(
                Decimal::fromFloat($amount, self::INNER_FRACTIONAL_DIGITS),
                $currency
            );
        } catch (InfiniteInputError $e) {
            throw new InvalidArgumentException('Currency amounts must be finite', 0, $e);
        } catch (NaNInputError $e) {
            throw new InvalidArgumentException('Currency amounts must be numbers', 0, $e);
        }
    }

    public static function fromFractionalUnits(int $amount, CurrencyContract $currency): Money
    {
        $decimalAmount = Decimal::fromInteger($amount)
            ->div(
                Decimal::fromInteger(10 ** $currency->getNumFractionalDigits()),
                self::INNER_FRACTIONAL_DIGITS
            );

        return new self($decimalAmount, $currency);
    }

    public static function fromString(string $amount, CurrencyContract $currency): Money
    {
        return new self(
            self::extractNumericAmount($amount, $currency),
            $currency
        );
    }

    private static function extractNumericAmount(string $amount, CurrencyContract $currency): Decimal
    {
        if (
            1 === \preg_match(self::SIMPLE_CURRENCY_PATTERN, $amount, $matches) ||
            1 === \preg_match(self::getAmountPlusIsoCodePattern($currency), $amount, $matches) ||
            1 === \preg_match(self::getAmountPlusSymbolPattern($currency), $amount, $matches)
        ) {
            return Decimal::fromString($matches['amount'], self::INNER_FRACTIONAL_DIGITS);
        }

        throw new InvalidArgumentException('Invalid currency value');
    }

    /**
     * @param CurrencyContract $currency
     *
     * @return string
     */
    private static function getAmountPlusIsoCodePattern(CurrencyContract $currency): string
    {
        $amountPlusIsoCodePattern = '/^'.self::DECIMAL_NUMBER_REGEXP.'\s*'.$currency->getISOCode().'$/x';

        return $amountPlusIsoCodePattern;
    }

    private static function getAmountPlusSymbolPattern(CurrencyContract $currency): string
    {
        $escapedSymbol = \preg_quote($currency->getSymbol(), '/');

        return (CurrencyContract::BEFORE_PLACEMENT === $currency->getSymbolPlacement())
            ? '/^'.$escapedSymbol.'\s*'.self::DECIMAL_NUMBER_REGEXP.'$/x'
            : '/^'.self::DECIMAL_NUMBER_REGEXP.'\s*'.$escapedSymbol.'$/x';
    }

    public static function fromDecimal(Decimal $amount, CurrencyContract $currency): Money
    {
        return new self(
            Decimal::fromDecimal($amount, self::INNER_FRACTIONAL_DIGITS),
            $currency
        );
    }

    public function getCurrency(): CurrencyContract
    {
        return $this->currency;
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
                Decimal::fromInteger(10 ** $this->currency->getNumFractionalDigits()),
                self::INNER_FRACTIONAL_DIGITS
            )
            ->asInteger();
    }

    /**
     * {@inheritdoc}
     */
    public function format(?MoneyFormatInterface $currencyFormat = null): string
    {
        if (is_null($currencyFormat)) {
            $currencyFormat = MoneyFormat::default();
        }

        $nDecimals = $currencyFormat->getPrecision();
        if (is_null($nDecimals)) {
            $nDecimals = $this->currency->getNumFractionalDigits() + $currencyFormat->getExtraPrecision();
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
     * @param string               $number
     * @param MoneyFormatInterface $currencyFormat
     *
     * @return string
     */
    private function decorate(string $number, MoneyFormatInterface $currencyFormat): string
    {
        $separator = (MoneyFormat::DECORATION_WITH_SPACE === $currencyFormat->getDecorationSpace())
            ? ' '
            : '';

        return match ($currencyFormat->getDecorationType()) {
            MoneyFormat::DECORATION_NO_DECORATION => $number,
            MoneyFormat::DECORATION_ISO_CODE => $number.$separator.$this->currency->getISOCode(),
            default => (CurrencyContract::BEFORE_PLACEMENT === $this->currency->getSymbolPlacement())
                ? $this->currency->getSymbol().$separator.$number
                : $number.$separator.$this->currency->getSymbol(),
        };
    }

    /**
     * {@inheritdoc}
     */
    public function equals(MoneyContract $currency): bool
    {
        return $currency === $this || (
                $this->amount->equals($currency->getAmountAsDecimal()) &&
                $this->currency->equals($currency->getCurrency())
            );
    }
}
