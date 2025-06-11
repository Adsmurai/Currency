<?php

namespace Adsmurai\Currency\Contracts;

interface MoneyFormat
{
    public const DECORATION_NO_DECORATION = 0;
    public const DECORATION_SYMBOL = 1;
    public const DECORATION_ISO_CODE = 2;
    public const DECORATION_WITH_SPACE = 1;
    public const DECORATION_WITHOUT_SPACE = 0;
    public const DEFAULT_DECIMALS_SEPARATOR = '.';
    public const DEFAULT_THOUSANDS_SEPARATOR = '';

    public function getDecimalsSeparator(): string;

    public function getThousandsSeparator(): string;

    public function getExtraPrecision(): int;

    public function getPrecision();

    public function getDecorationType(): int;

    public function getDecorationSpace(): int;
}
