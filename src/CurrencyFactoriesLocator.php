<?php

declare(strict_types=1);

namespace Adsmurai\Currency;

use Adsmurai\Currency\Contracts\CurrencyFactoriesLocator as CurrencyFactoriesLocatorInterface;
use Adsmurai\Currency\Contracts\MoneyFactory as CurrencyFactoryInterface;
use Adsmurai\Currency\Contracts\CurrencyFactory;

final class CurrencyFactoriesLocator implements CurrencyFactoriesLocatorInterface
{
    /** @var CurrencyFactory */
    private $currencyTypeFactory;

    /** @var MoneyFactory[] */
    private $currencyFactories;

    public function __construct(CurrencyFactory $currencyTypeFactory)
    {
        $this->currencyTypeFactory = $currencyTypeFactory;
    }

    public function getCurrencyFactory(string $isoCode): CurrencyFactoryInterface
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
