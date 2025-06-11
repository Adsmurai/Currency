<?php

declare(strict_types=1);

namespace Adsmurai\Currency;

use Adsmurai\Currency\Contracts\Currency as CurrencyContract;
use Adsmurai\Currency\Contracts\CurrencyFactory as CurrencyFactoryContract;
use Adsmurai\Currency\Errors\InvalidCurrenciesDataError;
use Adsmurai\Currency\Errors\UnsupportedCurrencyISOCodeError;

final class CurrencyFactory implements CurrencyFactoryContract
{
    const DEFAULT_DATA_PATH = __DIR__.'/Data/CurrencyTypes.php';

    /** @var Currency[] */
    private $currencies = [];

    private function __construct(private array $data)
    {
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
     * @throws InvalidCurrenciesDataError
     */
    private static function validateCurrenciesData(array $currenciesData)
    {
        if ($currenciesData === []) {
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
        return \is_string($ISOCode) && ($ISOCode !== '' && $ISOCode !== '0');
    }

    private static function hasValidSymbol(array $currencyData): bool
    {
        return
            isset($currencyData['symbol'])
            && \is_string($currencyData['symbol'])
            && (isset($currencyData['symbol']) && ($currencyData['symbol'] !== '' && $currencyData['symbol'] !== '0'));
    }

    private static function hasValidSymbolPlacement(array $currencyData): bool
    {
        return
            isset($currencyData['symbolPlacement'])
            && \is_int($currencyData['symbolPlacement'])
            && \in_array(
                $currencyData['symbolPlacement'],
                [
                    CurrencyContract::BEFORE_PLACEMENT,
                    CurrencyContract::AFTER_PLACEMENT,
                ]
            );
    }

    private static function hasValidNumFractionalDigits(array $currencyData): bool
    {
        return isset($currencyData['numFractionalDigits']) && \is_int($currencyData['numFractionalDigits']);
    }

    public function buildFromISOCode(string $ISOCode): CurrencyContract
    {
        if (!isset($this->data[$ISOCode])) {
            throw new UnsupportedCurrencyISOCodeError($ISOCode);
        }

        if (!isset($this->currencies[$ISOCode])) {
            $this->currencies[$ISOCode] = new Currency(
                $ISOCode,
                $this->data[$ISOCode]['symbol'],
                $this->data[$ISOCode]['numFractionalDigits'],
                $this->data[$ISOCode]['symbolPlacement'],
                (isset($this->data[$ISOCode]['name']) && !empty($this->data[$ISOCode]['name']))
                    ? $this->data[$ISOCode]['name']
                    : ''
            );
        }

        return $this->currencies[$ISOCode];
    }

    /** @return string[] */
    public function getSupportedCurrencyISOCodes(): array
    {
        return \array_keys($this->data);
    }

    /** @return Currency[] */
    public function getSupportedCurrencies(): array
    {
        foreach (array_keys($this->data) as $ISOCode) {
            $this->buildFromISOCode($ISOCode);
        }

        return array_values($this->currencies);
    }
}
