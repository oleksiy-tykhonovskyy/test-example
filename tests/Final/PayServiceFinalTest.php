<?php

declare(strict_types=1);

class PayServiceFinalTest extends \PHPUnit\Framework\TestCase
{
    private ExchangeCalculatorFinal $exchangeCalculator;
    private PaymentProcessorFinal $paymentProcessor;

    private PayServiceFinal $payService;

    protected function setUp(): void
    {
        $this->exchangeCalculator = new ExchangeCalculatorFinal();

        $this->paymentProcessor = new PaymentProcessorFinal($this->exchangeCalculator);

        $this->payService = new PayServiceFinal($this->paymentProcessor);
    }

    /**
     * @dataProvider successData
     */
    public function testPaySuccess(string $message): void
    {
        $this->assertTrue($this->payService->processPaymentMessage($message));
    }

    public static function successData(): array
    {
        return [
            'USD' => ['{"amount": 10, "currency": "USD"}'],
            'EUR' => ['{"amount": 10, "currency": "EUR"}'],
        ];
    }

    /**
     * @dataProvider successData
     */
    public function testPayReject(string $message): void
    {
        $this->assertTrue($this->payService->processPaymentMessage($message));
    }

    public static function rejectData(): array
    {
        return [
            'exceed USD' => ['{"amount": 1000, "currency": "USD"}'],
            'exceed EUR' => ['{"amount": 1000, "currency": "EUR"}'],
        ];
    }

    /**
     * @dataProvider exceptionData
     */
    public function testPayButException(string $message): void
    {
        self::expectException(\InvalidArgumentException::class);
        $this->payService->processPaymentMessage($message);
    }

    public static function exceptionData(): array
    {
        return [
            'not a json' => ['blabla'],
            'amount missed' => ['{"currency": "USD"}'],
            'currency missed' => ['{"amount": 100}'],
            'both missed' => ['{}'],
            'wrong currency' => ['{"amount": 10, "currency": "PLN"}'],
            'negative amount' => ['{"amount": -5, "currency": "usd"}'],
        ];
    }


}