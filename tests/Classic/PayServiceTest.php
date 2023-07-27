<?php

declare(strict_types=1);

class PayServiceTest extends \PHPUnit\Framework\TestCase
{
    private PaymentProcessor $paymentProcessor;

    private PayService $payService;

    protected function setUp(): void
    {
        $this->paymentProcessor = $this->createMock(PaymentProcessor::class);

        $this->payService = new PayService($this->paymentProcessor);
    }

    public function testPay(): void
    {
        $amount = 100;
        $currency = 'USD';

        $this->paymentProcessor->expects($this->once())
            ->method('pay')
            ->with($amount, $currency)
            ->willReturn(true);

        $this->assertTrue($this->payService->processPaymentMessage('{"amount": ' . $amount . ', "currency": "' . $currency . '"}'));
    }

    /**
     * @dataProvider dataProvider
     */
    public function testPayButWrongMessage(string $message): void
    {
        self::expectException(\InvalidArgumentException::class);

        $this->paymentProcessor->expects($this->never())->method('pay');

        $this->payService->processPaymentMessage($message);
    }

    public static function dataProvider(): array
    {
        return [
            'not a json' => ['blabla'],
            'amount missed' => ['{"currency": "USD"}'],
            'currency missed' => ['{"amount": 100}'],
            'both missed' => ['{}'],
        ];
    }
}