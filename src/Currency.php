<?php

declare(strict_types=1);

namespace Adsmurai\Currency;

use Adsmurai\Currency\Contracts\Currency as CurrencyInterface;
use Adsmurai\Currency\Errors\InconsistentCurrenciesError;
use InvalidArgumentException;

final class Currency implements CurrencyInterface
{
    private $ISOCode;

    private $name;

    private $symbol;

    private $numFractionalDigits;

    private $symbolPlacement;

    public function __construct(
        string $ISOCode,
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

        $this->ISOCode = $ISOCode;
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

    public function equals(CurrencyInterface $currencyType): bool
    {
        if ($this === $currencyType) {
            return true;
        }

        if ($currencyType->getISOCode() !== $this->ISOCode) {
            return false;
        }

        if (!(
            $currencyType->getName() === $this->name &&
            $currencyType->getSymbol() === $this->symbol &&
            $currencyType->getNumFractionalDigits() === $this->numFractionalDigits &&
            $currencyType->getSymbolPlacement() === $this->symbolPlacement
        )) {
            throw new InconsistentCurrenciesError($this, $currencyType);
        }

        return true;
    }
}
