<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Currency;
use Adsmurai\Currency\Contracts\CurrencyType;
use Litipk\BigNumbers\Decimal;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

final class CurrencyTypeMocks
{
    /**  @return CurrencyType|MockInterface */
    public static function getCurrencyTypeDummyMock(): CurrencyType
    {
        /** @var CurrencyType|MockInterface $currencyType */
        $currencyType = \Mockery::mock(CurrencyType::class);

        return $currencyType;
    }

    /**  @return CurrencyType|MockInterface */
    public static function getNDecimalDigitsCurrencyType(int $n = 2): CurrencyType
    {
        /** @var CurrencyType|MockInterface $currencyType */
        $currencyType = self::getCurrencyTypeDummyMock();
        $currencyType
            ->shouldReceive('getNumFractionalDigits')->andReturn($n);

        return $currencyType;
    }

    /**  @return CurrencyType|MockInterface */
    public static function getTwoDecimalDigitsCurrencyType(): CurrencyType
    {
        return self::getNDecimalDigitsCurrencyType(2);
    }

    /**  @return CurrencyType|MockInterface */
    public static function getComparableTwoDecimalDigitsCurrencyType(bool $equals = true): CurrencyType
    {
        /** @var CurrencyType|MockInterface $currencyType */
        $currencyType = self::getTwoDecimalDigitsCurrencyType();
        $currencyType->shouldReceive('equals')->andReturn($equals);

        return $currencyType;
    }

    public static function getEuroCurrencyType(): CurrencyType
    {
        /** @var CurrencyType|MockInterface $currencyType */
        $currencyType = \Mockery::mock(CurrencyType::class);

        $currencyType
            ->shouldReceive('getNumFractionalDigits')->andReturn(2)
            ->shouldReceive('getISOCode')->andReturn('EUR')
            ->shouldReceive('getSymbol')->andReturn('€')
            ->shouldReceive('getSymbolPlacement')->andReturn(CurrencyType::AFTER_PLACEMENT);

        return $currencyType;
    }

    public static function getUsDollarCurrencyType(): CurrencyType
    {
        /** @var CurrencyType|MockInterface $currencyType */
        $currencyType = \Mockery::mock(CurrencyType::class);

        $currencyType
            ->shouldReceive('getNumFractionalDigits')->andReturn(2)
            ->shouldReceive('getISOCode')->andReturn('USD')
            ->shouldReceive('getSymbol')->andReturn('$')
            ->shouldReceive('getSymbolPlacement')->andReturn(CurrencyType::BEFORE_PLACEMENT);

        return $currencyType;
    }
}
