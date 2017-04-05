<?php

namespace Adsmurai\Currency\Interfaces;

interface CurrencyTypeFactory
{
    public function getCurrencyType(string $ISOCode): CurrencyType;
}
