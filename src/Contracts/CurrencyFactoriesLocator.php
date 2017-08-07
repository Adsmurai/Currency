<?php

namespace Adsmurai\Currency\Contracts;

interface CurrencyFactoriesLocator
{
    public function getCurrencyFactory(string $isoCode): MoneyFactory;

    /** @return string[] */
    public function getSupportedCurrencyISOCodes(): array;
}
