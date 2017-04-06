<?php

namespace Adsmurai\Currency\Errors;

use Adsmurai\Currency\Contracts\CurrencyError;
use LogicException;

final class InvalidCurrencyTypesDataError extends LogicException implements CurrencyError
{
    public function __construct()
    {
        parent::__construct('Invalid currency types data');
    }
}
