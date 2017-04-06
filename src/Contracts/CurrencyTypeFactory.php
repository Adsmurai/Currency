<?php

namespace Adsmurai\Currency\Contracts;

interface CurrencyTypeFactory
{
    public function buildFromISOCode(string $ISOCode): CurrencyType;
}
