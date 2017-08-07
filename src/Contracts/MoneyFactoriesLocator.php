<?php

namespace Adsmurai\Currency\Contracts;

interface MoneyFactoriesLocator
{
    public function getMoneyFactory(string $isoCode): MoneyFactory;

    /** @return string[] */
    public function getSupportedCurrencyISOCodes(): array;
}
