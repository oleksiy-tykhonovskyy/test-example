<?php

declare(strict_types=1);

class PaymentProcessorTest extends \PHPUnit\Framework\TestCase
{
    private ExchangeCalculator $exchangeCalculator;
    private PaymentProcessor $paymentProcessor;
    protected function setUp(): void
    {
        $this->exchangeCalculator = $this->createMock(ExchangeCalculator::class);

        $this->paymentProcessor = new PaymentProcessor($this->exchangeCalculator);
    }

    public function testPay(): void
    {
        $this->exchangeCalculator->expects($this->once())
            ->method('getPlnAmount')
            ->with(100, 'USD')
            ->willReturn(100.0);

        $this->assertTrue($this->paymentProcessor->pay(100, 'USD'));
    }

    public function testPayButExceedQuote(): void
    {
        $this->exchangeCalculator->expects($this->once())
            ->method('getPlnAmount')
            ->with(1000, 'USD')
            ->willReturn(PaymentProcessor::PROCESSOR_LIMIT + 1.0);

        self::assertFalse($this->paymentProcessor->pay(1000, 'USD'));
    }
}