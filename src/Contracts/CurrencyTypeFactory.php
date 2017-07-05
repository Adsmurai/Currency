<?php

namespace Adsmurai\Currency\Contracts;

interface CurrencyTypeFactory
{
    public function buildFromISOCode(string $ISOCode): CurrencyType;

    /** @return string[] */
    public function getSupportedCurrencyISOCodes(): array;
}
