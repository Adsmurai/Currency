<?php

declare(strict_types=1);

namespace Adsmurai\Currency;

use Adsmurai\Currency\Contracts\Money as MoneyContract;
use Adsmurai\Currency\Contracts\MoneyFormat as MoneyFormatInterface;
use Adsmurai\Currency\Contracts\Currency as CurrencyContract;
use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use InvalidArgumentException;

final class Money implements MoneyContract
{
    public const DECIMAL_NUMBER_REGEXP = '(?P<amount> 0*(([1-9]\d*|\d)(\.\d+)?))';
    public const SIMPLE_CURRENCY_PATTERN = '/^'.self::DECIMAL_NUMBER_REGEXP.'$/x';
    public const INNER_FRACTIONAL_DIGITS = 8;

    private function __construct(private readonly BigDecimal $amount, private readonly CurrencyContract $currency)
    {
    }

    public static function fromFloat(float $amount, CurrencyContract $currency): Money
    {
        if (!is_finite($amount) && !is_nan($amount)) {
            throw new InvalidArgumentException('Currency amounts must be finite');
        }

        if (is_nan($amount)) {
            throw new InvalidArgumentException('Currency amounts must be numbers');
        }

        return new self(
            BigDecimal::of($amount)->toScale(self::INNER_FRACTIONAL_DIGITS, RoundingMode::HALF_UP),
            $currency
        );
    }

    public static function fromFractionalUnits(int $amount, CurrencyContract $currency): Money
    {
        $decimalAmount = BigDecimal::of($amount)
            ->dividedBy(
                BigDecimal::of(10 ** $currency->getNumFractionalDigits()),
                self::INNER_FRACTIONAL_DIGITS,
                RoundingMode::HALF_UP
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

    private static function extractNumericAmount(string $amount, CurrencyContract $currency): BigDecimal
    {
        if (
            1 === \preg_match(self::SIMPLE_CURRENCY_PATTERN, $amount, $matches) ||
            1 === \preg_match(self::getAmountPlusIsoCodePattern($currency), $amount, $matches) ||
            1 === \preg_match(self::getAmountPlusSymbolPattern($currency), $amount, $matches)
        ) {
            return BigDecimal::of($matches['amount'])->toScale(self::INNER_FRACTIONAL_DIGITS, RoundingMode::HALF_UP);
        }

        throw new InvalidArgumentException('Invalid currency value');
    }

    private static function getAmountPlusIsoCodePattern(CurrencyContract $currency): string
    {
        return '/^'.self::DECIMAL_NUMBER_REGEXP.'\s*'.$currency->getISOCode().'$/x';
    }

    private static function getAmountPlusSymbolPattern(CurrencyContract $currency): string
    {
        $escapedSymbol = \preg_quote($currency->getSymbol(), '/');

        return (CurrencyContract::BEFORE_PLACEMENT === $currency->getSymbolPlacement())
            ? '/^'.$escapedSymbol.'\s*'.self::DECIMAL_NUMBER_REGEXP.'$/x'
            : '/^'.self::DECIMAL_NUMBER_REGEXP.'\s*'.$escapedSymbol.'$/x';
    }

    public static function fromDecimal(BigDecimal $amount, CurrencyContract $currency): Money
    {
        return new self(
            $amount->toScale(self::INNER_FRACTIONAL_DIGITS, RoundingMode::HALF_UP),
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
    public function getAmountAsDecimal(): BigDecimal
    {
        return $this->amount;
    }

    /**
     * {@inheritdoc}
     */
    public function getAmountAsFractionalUnits(): int
    {
        return $this->amount
            ->multipliedBy(
                BigDecimal::of(10 ** $this->currency->getNumFractionalDigits())
            )
            ->toScale(self::INNER_FRACTIONAL_DIGITS, RoundingMode::HALF_UP)
            ->toInt();
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

        $amount = $this->amount->toScale($nDecimals, RoundingMode::HALF_UP);

        $number = ('' === $currencyFormat->getThousandsSeparator())
            ? \str_replace('.', $currencyFormat->getDecimalsSeparator(), $amount->__toString())  // This is safer!
            : \number_format(
                $amount->toFloat(),
                $nDecimals,
                $currencyFormat->getDecimalsSeparator(),
                $currencyFormat->getThousandsSeparator()
            );

        return $this->decorate($number, $currencyFormat);
    }

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
            $this->amount->isEqualTo($currency->getAmountAsDecimal()) &&
                $this->currency->equals($currency->getCurrency())
        );
    }
}
