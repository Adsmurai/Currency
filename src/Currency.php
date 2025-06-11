<?php

declare(strict_types=1);

namespace Adsmurai\Currency;

use Adsmurai\Currency\Contracts\Currency as CurrencyContract;
use Adsmurai\Currency\Errors\InconsistentCurrenciesError;
use InvalidArgumentException;

final class Currency implements CurrencyContract
{
    private $name;

    private $symbol;

    private $numFractionalDigits;

    private $symbolPlacement;

    public function __construct(
        private string $ISOCode,
        string $symbol,
        int $numFractionalDigits,
        int $symbolPlacement = self::AFTER_PLACEMENT,
        string $name = ''
    ) {
        $symbol = \trim($symbol);
        $name = \trim($name);

        if (!in_array($symbolPlacement, [self::BEFORE_PLACEMENT, self::AFTER_PLACEMENT])) {
            throw new InvalidArgumentException('Invalid symbol placement');
        }

        if ($numFractionalDigits < 0 || $numFractionalDigits > 8) {
            throw new InvalidArgumentException('Invalid number of fractional digits');
        }

        if ('' === $symbol) {
            throw new InvalidArgumentException('Empty symbol');
        }
        $this->symbol = $symbol;
        $this->numFractionalDigits = $numFractionalDigits;
        $this->symbolPlacement = $symbolPlacement;
        $this->name = $name;
    }

    public function getISOCode(): string
    {
        return $this->ISOCode;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getNumFractionalDigits(): int
    {
        return $this->numFractionalDigits;
    }

    public function getSymbolPlacement(): int
    {
        return $this->symbolPlacement;
    }

    public function equals(CurrencyContract $currency): bool
    {
        if ($this === $currency) {
            return true;
        }

        if ($currency->getISOCode() !== $this->ISOCode) {
            return false;
        }

        if (!(
            $currency->getName() === $this->name &&
            $currency->getSymbol() === $this->symbol &&
            $currency->getNumFractionalDigits() === $this->numFractionalDigits &&
            $currency->getSymbolPlacement() === $this->symbolPlacement
        )) {
            throw new InconsistentCurrenciesError($this, $currency);
        }

        return true;
    }
}
