<?php

namespace Adsmurai\Currency\Contracts;

interface CurrencyFactoriesLocator
{
    public function getCurrencyFactory(string $isoCode): CurrencyFactory;

    /** @return string[] */
    public function getSupportedCurrencyISOCodes(): array;
}
