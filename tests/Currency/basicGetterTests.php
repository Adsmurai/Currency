<?php
declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Currency;
use Adsmurai\Currency\Interfaces\CurrencyType;
use Litipk\BigNumbers\Decimal;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class basicGetterTests extends TestCase
{
    /**
     * @covers \Adsmurai\Currency\Currency::getAmountAsDecimal
     * @covers \Adsmurai\Currency\Currency::getCurrencyType
     */
    public function test_basic_getters()
    {
        // TODO: Improve the test to decouple from Decimal. It requires refactoring Decimal.

        $amount = Decimal::fromString('34.56');
        $currencyType = $this->getTwoDecimalDigitsCurrencyType();

        $currency = Currency::fromDecimal($amount, $currencyType);

        $this->assertSame($amount, $currency->getAmountAsDecimal());
        $this->assertSame($currencyType, $currency->getCurrencyType());
    }

    private static function getTwoDecimalDigitsCurrencyType(): CurrencyType
    {
        /** @var CurrencyType|MockInterface $currencyType */
        $currencyType = \Mockery::mock(CurrencyType::class);

        $currencyType
            ->shouldReceive('getNumFractionalDigits')
            ->andReturn(2);

        return $currencyType;
    }
}
