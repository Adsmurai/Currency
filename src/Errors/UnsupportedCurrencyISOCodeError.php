<?php

namespace Adsmurai\Currency\Errors;

use Adsmurai\Currency\Contracts\CurrencyError;
use LogicException;

final class UnsupportedCurrencyISOCodeError extends LogicException implements CurrencyError
{
    public function __construct(string $ISOCode)
    {
        parent::__construct("Unsupported currency ISO code ($ISOCode)");
    }
}
