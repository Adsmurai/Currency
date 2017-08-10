<?php

declare(strict_types=1);

namespace Adsmurai\Currency;

use Adsmurai\Currency\Contracts\MoneyFactoriesLocator as MoneyFactoriesLocatorContract;
use Adsmurai\Currency\Contracts\MoneyFactory as MoneyFactoryContract;
use Adsmurai\Currency\Contracts\CurrencyFactory as CurrencyFactoryContract;

final class MoneyFactoriesLocator implements MoneyFactoriesLocatorContract
{
    /** @var CurrencyFactoryContract */
    private $currencyFactory;

    /** @var MoneyFactory[] */
    private $moneyFactories;

    public function __construct(CurrencyFactoryContract $currencyFactory)
    {
        $this->currencyFactory = $currencyFactory;
    }

    public function getMoneyFactory(string $isoCode): MoneyFactoryContract
    {
        if (!isset($this->moneyFactories[$isoCode])) {
            $this->moneyFactories[$isoCode] = new MoneyFactory(
                $this->currencyFactory->buildFromISOCode($isoCode)
            );
        }

        return $this->moneyFactories[$isoCode];
    }

    /** @return string[] */
    public function getSupportedCurrencyISOCodes(): array
    {
        return $this->currencyFactory->getSupportedCurrencyISOCodes();
    }
}
