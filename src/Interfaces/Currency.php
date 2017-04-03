<?php

namespace Adsmurai\Currency\Interfaces;

use Litipk\BigNumbers\Decimal;

interface Currency
{
    public function getCurrencyType(): CurrencyType;

    /**
     * WARNING: This method is not meant to be used in currency formatting code nor currency representation code.
     *
     * This method returns the monetary amount as a string representing a decimal number. Its meant to be used in
     * fixed precision mathematical operations, like the ones that can be done with libraries like BCMath.
     *
     * @return Decimal
     */
    public function getAmountAsDecimal(): Decimal;

    /**
     * WARNING: This method is not meant to be used in currency formatting code nor currency representation code.
     *
     * Every currency has a minimum fractional unit that can be used for commercial transactions. Examples:
     *  - euros (EUR)           1/100   = 0.01
     *  - bahraini dinars (BHD) 1/1000  = 0.001.
     *
     * This method returns the monetary amount measured in currency's minimum fractional units. Examples:
     *  - 171.43 €   ->  17143
     *  - 56.611 BD  ->  56611
     *
     * @return int
     */
    public function getAmountAsFractionalUnits(): int;

    /**
     * Use this method to represent monetary amounts as strings.
     *
     * @param string $decimalsSeparator
     * @param string $thousandsSeparator
     * @param int $extraPrecision Use this parameter to represent monetary amounts below the currency precision.
     * @return string
     */
    public function format(string $decimalsSeparator='.', $thousandsSeparator='', int $extraPrecision=0): string;

    /**
     * Use this method to compare currency values.
     * It will return false if the amount or the currency types don't match.
     *
     * @param Currency $currency
     * @return bool
     */
    public function equals(Currency $currency): bool;
}
