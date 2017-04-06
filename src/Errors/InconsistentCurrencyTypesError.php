<?php

namespace Adsmurai\Currency\Errors;

use Adsmurai\Currency\Contracts\CurrencyError;
use Adsmurai\Currency\Contracts\CurrencyType;
use LogicException;

final class InconsistentCurrencyTypesError extends LogicException implements CurrencyError
{
    /** @var CurrencyType */
    private $ct1;
    /** @var CurrencyType */
    private $ct2;

    public function __construct(CurrencyType $ct1, CurrencyType $ct2)
    {
        $this->ct1 = $ct1;
        $this->ct2 = $ct2;

        if ($ct1 === $ct2) {
            throw new LogicException(
                'Trying to construct InconsistentCurrencyTypesError with exactly equal CurrencyType instances'
            );
        }

        parent::__construct('Same ISO currency code but different currency settings', 0, null);
    }

    /**
     * @return CurrencyType[]
     */
    public function getInconsistentCurrencyTypes(): array
    {
        return [$this->ct1, $this->ct2];
    }
}
