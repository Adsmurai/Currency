<?php

namespace Adsmurai\Currency\Contracts;

interface CurrencyFactory
{
    public function buildFromISOCode(string $ISOCode): Currency;

    /** @return string[] */
    public function getSupportedCurrencyISOCodes(): array;
}
