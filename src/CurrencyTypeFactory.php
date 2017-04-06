<?php
declare(strict_types=1);

namespace Adsmurai\Currency;

use Adsmurai\Currency\Errors\InvalidCurrencyTypesDataError;
use Adsmurai\Currency\Contracts\CurrencyType as CurrencyTypeInterface;
use Adsmurai\Currency\Contracts\CurrencyTypeFactory as CurrencyTypeFactoryInterface;

class CurrencyTypeFactory implements CurrencyTypeFactoryInterface
{
    const DEFAULT_DATA_PATH = __DIR__ . '/Data/CurrencyTypes.php';

    /** @var array */
    private $data;

    /** @var CurrencyType[] */
    private $currencyTypes;

    private function __construct(array $data)
    {
        $this->data = $data;
        $this->currencyTypes = [];
    }

    public static function fromDataArray(array $data): CurrencyTypeFactory
    {
        self::validateCurrenciesData($data);
        return new self($data);
    }

    public static function fromDataPath(string $dataPath = self::DEFAULT_DATA_PATH): CurrencyTypeFactory
    {
        /** @var array $data */
        $data = include($dataPath);
        return self::fromDataArray($data);
    }

    public function buildFromISOCode(string $ISOCode): CurrencyTypeInterface
    {
        if (!isset($this->currencyTypes[$ISOCode])) {
            $this->currencyTypes[$ISOCode] = new CurrencyType(
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

    /**
     * @param array $currenciesData
     * @throws InvalidCurrencyTypesDataError
     */
    private static function validateCurrenciesData(array $currenciesData)
    {
        if (empty($currenciesData)) {
            throw new InvalidCurrencyTypesDataError();
        }

        foreach ($currenciesData as $ISOCode => $currencyData) {
            if (
                   !self::hasValidISOCode($ISOCode)
                || !self::hasValidSymbol($currencyData)
                || !self::hasValidSymbolPlacement($currencyData)
                || !self::hasValidNumFractionalDigits($currencyData)
            ) {
                throw new InvalidCurrencyTypesDataError();
            }
        }
    }

    private static function hasValidISOCode($ISOCode): bool
    {
        return (\is_string($ISOCode) && !empty($ISOCode));
    }

    private static function hasValidSymbol(array $currencyData): bool
    {
        return (
            isset($currencyData['symbol'])
            && \is_string($currencyData['symbol'])
            && !empty($currencyData['symbol'])
        );
    }

    private static function hasValidSymbolPlacement(array $currencyData): bool
    {
        return (
            isset($currencyData['symbolPlacement'])
            && \is_int($currencyData['symbolPlacement'])
            && \in_array(
                $currencyData['symbolPlacement'],
                [
                    CurrencyTypeInterface::BEFORE_PLACEMENT,
                    CurrencyTypeInterface::AFTER_PLACEMENT
                ]
            )
        );
    }

    private static function hasValidNumFractionalDigits(array $currencyData): bool
    {
        return (isset($currencyData['numFractionalDigits']) && \is_int($currencyData['numFractionalDigits']));
    }
}
