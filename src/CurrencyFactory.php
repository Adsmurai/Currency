<?php

declare(strict_types=1);

namespace Adsmurai\Currency;

use Adsmurai\Currency\Contracts\Currency as CurrencyInterface;
use Adsmurai\Currency\Contracts\CurrencyFactory as CurrencyFactoryInterface;
use Adsmurai\Currency\Errors\InvalidCurrenciesDataError;
use Adsmurai\Currency\Errors\UnsupportedCurrencyISOCodeError;

final class CurrencyFactory implements CurrencyFactoryInterface
{
    const DEFAULT_DATA_PATH = __DIR__.'/Data/CurrencyTypes.php';

    /** @var array */
    private $data;

    /** @var Currency[] */
    private $currencyTypes;

    private function __construct(array $data)
    {
        $this->data = $data;
        $this->currencyTypes = [];
    }

    public static function fromDataPath(string $dataPath = self::DEFAULT_DATA_PATH): CurrencyFactory
    {
        /** @var array $data */
        $data = include $dataPath;

        return self::fromDataArray($data);
    }

    public static function fromDataArray(array $data): CurrencyFactory
    {
        self::validateCurrenciesData($data);

        return new self($data);
    }

    /**
     * @param array $currenciesData
     *
     * @throws InvalidCurrenciesDataError
     */
    private static function validateCurrenciesData(array $currenciesData)
    {
        if (empty($currenciesData)) {
            throw new InvalidCurrenciesDataError();
        }

        foreach ($currenciesData as $ISOCode => $currencyData) {
            if (
                !self::hasValidISOCode($ISOCode)
                || !self::hasValidSymbol($currencyData)
                || !self::hasValidSymbolPlacement($currencyData)
                || !self::hasValidNumFractionalDigits($currencyData)
            ) {
                throw new InvalidCurrenciesDataError();
            }
        }
    }

    private static function hasValidISOCode($ISOCode): bool
    {
        return \is_string($ISOCode) && !empty($ISOCode);
    }

    private static function hasValidSymbol(array $currencyData): bool
    {
        return
            isset($currencyData['symbol'])
            && \is_string($currencyData['symbol'])
            && !empty($currencyData['symbol']);
    }

    private static function hasValidSymbolPlacement(array $currencyData): bool
    {
        return
            isset($currencyData['symbolPlacement'])
            && \is_int($currencyData['symbolPlacement'])
            && \in_array(
                $currencyData['symbolPlacement'],
                [
                    CurrencyInterface::BEFORE_PLACEMENT,
                    CurrencyInterface::AFTER_PLACEMENT,
                ]
            );
    }

    private static function hasValidNumFractionalDigits(array $currencyData): bool
    {
        return isset($currencyData['numFractionalDigits']) && \is_int($currencyData['numFractionalDigits']);
    }

    public function buildFromISOCode(string $ISOCode): CurrencyInterface
    {
        if (!isset($this->data[$ISOCode])) {
            throw new UnsupportedCurrencyISOCodeError($ISOCode);
        }

        if (!isset($this->currencyTypes[$ISOCode])) {
            $this->currencyTypes[$ISOCode] = new Currency(
                $ISOCode,
                $this->data[$ISOCode]['symbol'],
                $this->data[$ISOCode]['numFractionalDigits'],
                $this->data[$ISOCode]['symbolPlacement'],
                (isset($this->data[$ISOCode]['name']) && !empty($this->data[$ISOCode]['name']))
                    ? $this->data[$ISOCode]['name']
                    : ''
            );
        }

        return $this->currencyTypes[$ISOCode];
    }

    /** @return string[] */
    public function getSupportedCurrencyISOCodes(): array
    {
        return \array_keys($this->data);
    }
}
