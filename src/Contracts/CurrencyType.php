<?php

namespace Adsmurai\Currency\Contracts;

interface CurrencyType
{
    const BEFORE_PLACEMENT = 0;
    const AFTER_PLACEMENT = 1;

    public function getISOCode(): string;

    public function getName(): string;

    public function getSymbol(): string;

    public function getNumFractionalDigits(): int;

    public function getSymbolPlacement(): int;

    public function equals(CurrencyType $currencyType): bool;
}
