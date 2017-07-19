<?php

namespace Adsmurai\Currency\Contracts;

interface CurrencyFormat
{
    public function getDecimalsSeparator(): string;

    public function getThousandsSeparator(): string;

    public function getExtraPrecision(): int;
}
