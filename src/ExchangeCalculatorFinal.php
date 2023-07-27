<?php

declare(strict_types=1);

final class ExchangeCalculatorFinal
{
    public const PROCESSED_CURRENCY = ['USD', 'EUR'];

    public function getPlnAmount(float $amountFrom, string $currencyFrom): float
    {
        if (!in_array($currencyFrom, self::PROCESSED_CURRENCY)) {
            throw new \InvalidArgumentException('Currency not supported');
        }

        if ($amountFrom < 0) {
            throw new \InvalidArgumentException('Amount must be positive');
        }

        return (float)$amountFrom * $this->getExchangeRate($currencyFrom);
    }

    private function getExchangeRate(string $currency): float
    {
        //should be fetched from external API, but for the sake of simplicity we will use hardcoded values
        return match ($currency) {
            'USD' => 3.8,
            'EUR' => 4.5,
        };
    }
}