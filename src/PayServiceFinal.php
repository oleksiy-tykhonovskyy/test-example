<?php

declare(strict_types=1);

class PayServiceFinal
{
    public function __construct(
        private readonly PaymentProcessorFinal $paymentProcessor,
    ) {}

    public function processPaymentMessage(string $message): bool
    {
        $data = json_decode($message, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid JSON');
        }

        if (!array_key_exists('amount', $data)
            || !array_key_exists('currency', $data)
        ) {
            throw new \InvalidArgumentException('Missing amount or currency');
        }

        return $this->paymentProcessor->pay($data['amount'], $data['currency']);
    }
}