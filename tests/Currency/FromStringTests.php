<?php

declare(strict_types=1);

namespace Adsmurai\Currency\Tests\Currency;

use Adsmurai\Currency\Currency;
use Adsmurai\Currency\Contracts\Currency as CurrencyInterface;
use Adsmurai\Currency\Contracts\CurrencyType;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class fromStringTests extends TestCase
{
    const TEST_ISO_CODE = 'EUR';

    /**
     * @dataProvider validParamsProvider
     * @covers \Adsmurai\Currency\Currency::extractNumericAmount
     * @covers \Adsmurai\Currency\Currency::fromString
     * @covers \Adsmurai\Currency\Currency::__construct
     */
    public function test_with_valid_params(string $amount, CurrencyType $currencyType)
    {
        $currency = Currency::fromString($amount, $currencyType);

        $this->assertInstanceOf(CurrencyInterface::class, $currency);
        $this->assertInstanceOf(Currency::class, $currency);
    }

    /**
     * @covers \Adsmurai\Currency\Currency::fromString
     * @covers \Adsmurai\Currency\Currency::extractNumericAmount
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid currency ISO code, expected EUR, but received USD
     */
    public function test_with_invalid_isoCode_suffix()
    {
        Currency::fromString('100 USD', $this->getTwoDecimalDigitsCurrencyType());
    }

    /**
     * @covers \Adsmurai\Currency\Currency::fromString
     * @covers \Adsmurai\Currency\Currency::extractNumericAmount
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid currency value
     */
    public function test_with_valid_currency_value_plus_noise()
    {
        Currency::fromString('100 EUR USD', $this->getTwoDecimalDigitsCurrencyType());
    }

    /**
     * @dataProvider negativeParamsProvider
     * @covers \Adsmurai\Currency\Currency::fromString
     * @covers \Adsmurai\Currency\Currency::__construct
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Currency amounts must be positive
     */
    public function test_with_negative_params(string $amount, CurrencyType $currencyType)
    {
        Currency::fromString($amount, $currencyType);
    }

    /**
     * @dataProvider notNumericParamsProvider
     * @covers \Adsmurai\Currency\Currency::fromString
     * @covers \Adsmurai\Currency\Currency::__construct
     * @covers \Adsmurai\Currency\Currency::extractNumericAmount
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Currency amounts must be numbers
     */
    public function test_with_not_numeric_param(string $amount, CurrencyType $currencyType)
    {
        Currency::fromString($amount, $currencyType);
    }

    public function validParamsProvider(): array
    {
        return [
            ['34.76', $this->getTwoDecimalDigitsCurrencyType()],
            ['100', $this->getTwoDecimalDigitsCurrencyType()],
            ['0.01', $this->getTwoDecimalDigitsCurrencyType()],
            ['12345678.50', $this->getTwoDecimalDigitsCurrencyType()],
            ['34.76 '.self::TEST_ISO_CODE, $this->getTwoDecimalDigitsCurrencyType()],
            ['100 '.self::TEST_ISO_CODE, $this->getTwoDecimalDigitsCurrencyType()],
            ['0.01 '.self::TEST_ISO_CODE, $this->getTwoDecimalDigitsCurrencyType()],
            ['12345678.50 '.self::TEST_ISO_CODE, $this->getTwoDecimalDigitsCurrencyType()],
        ];
    }

    public function negativeParamsProvider(): array
    {
        return [
            ['-34.76', $this->getTwoDecimalDigitsCurrencyType()],
            ['-100', $this->getTwoDecimalDigitsCurrencyType()],
            ['-0.01', $this->getTwoDecimalDigitsCurrencyType()],
            ['-12345678.50', $this->getTwoDecimalDigitsCurrencyType()],
        ];
    }

    public function notNumericParamsProvider(): array
    {
        return [
            ['', $this->getTwoDecimalDigitsCurrencyType()],
            ['hello world', $this->getTwoDecimalDigitsCurrencyType()],
            ['45.035,56', $this->getTwoDecimalDigitsCurrencyType()],
            ['45,035.56', $this->getTwoDecimalDigitsCurrencyType()],
        ];
    }

    private static function getTwoDecimalDigitsCurrencyType(): CurrencyType
    {
        /** @var CurrencyType|MockInterface $currencyType */
        $currencyType = \Mockery::mock(CurrencyType::class);

        $currencyType
            ->shouldReceive('getNumFractionalDigits')
            ->andReturn(2);

        $currencyType
            ->shouldReceive('getISOCode')
            ->andReturn(self::TEST_ISO_CODE);

        return $currencyType;
    }
}
