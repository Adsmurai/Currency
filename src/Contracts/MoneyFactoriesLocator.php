<?php

namespace Adsmurai\Currency\Contracts;

interface MoneyFactoriesLocator
{
    public function getCurrencyFactory(string $isoCode): MoneyFactory;

    /** @return string[] */
    public function getSupportedCurrencyISOCodes(): array;
}
