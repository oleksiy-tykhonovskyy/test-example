<?php

declare(strict_types=1);

final class PaymentProcessorFinal
{
    public function __construct(
        private readonly ExchangeCalculatorFinal $exchangeCalculator,
    ) {}

    public function pay(float $amount, string $currency): bool
    {
        $amountToPay = $this->exchangeCalculator->getPlnAmount($amount, $currency);

        if (400 < $amountToPay) {
            echo 'Limit exceeded for the current processor';

            return false;
        }

        return true;
    }
}