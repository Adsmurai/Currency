<?php

declare(strict_types=1);

namespace Adsmurai\Currency;

use Adsmurai\Currency\Contracts\CurrencyFactoriesLocator as CurrencyFactoriesLocatorInterface;
use Adsmurai\Currency\Contracts\CurrencyFactory as CurrencyFactoryInterface;
use Adsmurai\Currency\Contracts\CurrencyTypeFactory;

final class CurrencyFactoriesLocator implements CurrencyFactoriesLocatorInterface
{
    /** @var CurrencyTypeFactory */
    private $currencyTypeFactory;

    /** @var CurrencyFactory[] */
    private $currencyFactories;

    public function __construct(CurrencyTypeFactory $currencyTypeFactory)
    {
        $this->currencyTypeFactory = $currencyTypeFactory;
    }

    public function getCurrencyFactory(string $isoCode): CurrencyFactoryInterface
    {
        if (!isset($this->currencyFactories[$isoCode])) {
            $this->currencyFactories[$isoCode] = new CurrencyFactory(
                $this->currencyTypeFactory->buildFromISOCode($isoCode)
            );
        }

        return $this->currencyFactories[$isoCode];
    }
}
