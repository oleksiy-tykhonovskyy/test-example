<?php

declare(strict_types=1);

class PaymentProcessor
{
    public const PROCESSOR_LIMIT = 400;

    public function __construct(
        private readonly ExchangeCalculator $exchangeCalculator,
    ) {}

    public function pay(int $amount, string $currency): bool
    {
        $amountToPay = $this->exchangeCalculator->getPlnAmount($amount, $currency);

        if (self::PROCESSOR_LIMIT < $amountToPay) {
            echo 'Limit exceeded for the current processor';

            return false;
        }

        return true;
    }
}