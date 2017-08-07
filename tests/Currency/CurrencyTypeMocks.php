<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Contracts\Currency;
use Mockery\MockInterface;

final class CurrencyTypeMocks
{
    /**  @return Currency|MockInterface */
    public static function getComparableTwoDecimalDigitsCurrencyType(bool $equals = true): Currency
    {
        /** @var Currency|MockInterface $currencyType */
        $currencyType = self::getTwoDecimalDigitsCurrencyType();
        $currencyType->shouldReceive('equals')->andReturn($equals);

        return $currencyType;
    }

    /**  @return Currency|MockInterface */
    public static function getTwoDecimalDigitsCurrencyType(): Currency
    {
        return self::getNDecimalDigitsCurrencyType(2);
    }

    /**  @return Currency|MockInterface */
    public static function getNDecimalDigitsCurrencyType(int $n = 2): Currency
    {
        /** @var Currency|MockInterface $currencyType */
        $currencyType = self::getCurrencyTypeDummyMock();
        $currencyType
            ->shouldReceive('getNumFractionalDigits')->andReturn($n);

        return $currencyType;
    }

    /**  @return Currency|MockInterface */
    public static function getCurrencyTypeDummyMock(): Currency
    {
        /** @var Currency|MockInterface $currencyType */
        $currencyType = \Mockery::mock(Currency::class);

        return $currencyType;
    }

    public static function getEuroCurrencyType(): Currency
    {
        /** @var Currency|MockInterface $currencyType */
        $currencyType = \Mockery::mock(Currency::class);

        $currencyType
            ->shouldReceive('getNumFractionalDigits')->andReturn(2)
            ->shouldReceive('getISOCode')->andReturn('EUR')
            ->shouldReceive('getSymbol')->andReturn('€')
            ->shouldReceive('getSymbolPlacement')->andReturn(Currency::AFTER_PLACEMENT);

        return $currencyType;
    }

    public static function getUsDollarCurrencyType(): Currency
    {
        /** @var Currency|MockInterface $currencyType */
        $currencyType = \Mockery::mock(Currency::class);

        $currencyType
            ->shouldReceive('getNumFractionalDigits')->andReturn(2)
            ->shouldReceive('getISOCode')->andReturn('USD')
            ->shouldReceive('getSymbol')->andReturn('$')
            ->shouldReceive('getSymbolPlacement')->andReturn(Currency::BEFORE_PLACEMENT);

        return $currencyType;
    }
}
