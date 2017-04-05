<?php

namespace Adsmurai\Currency\Interfaces;

interface CurrencyTypeFactory
{
    public function buildFromISOCode(string $ISOCode): CurrencyType;
}
