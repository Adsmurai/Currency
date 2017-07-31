<?php

namespace Adsmurai\Currency\Contracts;

interface CurrencyFormat
{
    const DECORATION_NO_DECORATION = 0;
    const DECORATION_SYMBOL = 1;
    const DECORATION_ISO_CODE = 2;

    public function getDecimalsSeparator(): string;

    public function getThousandsSeparator(): string;

    public function getExtraPrecision(): int;

    public function getPrecision();

    public function getDecorationType(): int;
}
