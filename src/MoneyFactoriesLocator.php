<?php

declare(strict_types=1);

namespace Adsmurai\Currency;

use Adsmurai\Currency\Contracts\MoneyFactoriesLocator as MoneyFactoriesLocatorInterface;
use Adsmurai\Currency\Contracts\MoneyFactory as MoneyFactoryInterface;
use Adsmurai\Currency\Contracts\CurrencyFactory;

final class MoneyFactoriesLocator implements MoneyFactoriesLocatorInterface
{
    /** @var CurrencyFactory */
    private $currencyTypeFactory;

    /** @var MoneyFactory[] */
    private $currencyFactories;

    public function __construct(CurrencyFactory $currencyTypeFactory)
    {
        $this->currencyTypeFactory = $currencyTypeFactory;
    }

    public function getMoneyFactory(string $isoCode): MoneyFactoryInterface
    {
        if (!isset($this->currencyFactories[$isoCode])) {
            $this->currencyFactories[$isoCode] = new MoneyFactory(
                $this->currencyTypeFactory->buildFromISOCode($isoCode)
            );
        }

        return $this->currencyFactories[$isoCode];
    }

    /** @return string[] */
    public function getSupportedCurrencyISOCodes(): array
    {
        return $this->currencyTypeFactory->getSupportedCurrencyISOCodes();
    }
}
