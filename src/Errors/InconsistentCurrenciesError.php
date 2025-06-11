<?php

namespace Adsmurai\Currency\Errors;

use Adsmurai\Currency\Contracts\CurrencyError;
use Adsmurai\Currency\Contracts\Currency;
use LogicException;

final class InconsistentCurrenciesError extends LogicException implements CurrencyError
{
    public function __construct(private readonly Currency $ct1, private readonly Currency $ct2)
    {
        if ($this->ct1 === $this->ct2) {
            throw new LogicException(
                'Trying to construct InconsistentCurrencyTypesError with exactly equal CurrencyType instances'
            );
        }

        parent::__construct('Same ISO currency code but different currency settings');
    }

    /**
     * @return Currency[]
     */
    public function getInconsistentCurrencyTypes(): array
    {
        return [$this->ct1, $this->ct2];
    }
}
