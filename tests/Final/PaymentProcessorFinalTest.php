<?php

declare(strict_types=1);

class PaymentProcessorFinalTest extends \PHPUnit\Framework\TestCase
{
    private ExchangeCalculatorFinal $exchangeCalculator;
    private PaymentProcessorFinal $paymentProcessor;

    protected function setUp(): void
    {
        $this->exchangeCalculator = new ExchangeCalculatorFinal();

        $this->paymentProcessor = new PaymentProcessorFinal($this->exchangeCalculator);
    }

    /**
     * @dataProvider regularData
     */
    public function testPay(bool $expectedResult, float $amount, string $currency): void
    {
        $this->assertEquals($expectedResult, $this->paymentProcessor->pay($amount, $currency));
    }

    public static function regularData(): array
    {
       return [
           'ok USD' => [true, 10, 'USD'],
           'exceed USD' => [false, 1000, 'USD'],
           'ok EUR' => [true, 10, 'EUR'],
           'exceed EUR' => [false, 1000, 'EUR'],
       ];
    }


    /**
     * @dataProvider exceptionData
     */
    public function testPayButException(float $amount, string $currency): void
    {
        self::expectException(\InvalidArgumentException::class);
        $this->paymentProcessor->pay($amount, $currency);
    }

    public static function exceptionData(): array
    {
       return [
           'negative amount' => [-10, 'USD'],
           'wrong currency' => [10, 'PLN'],
       ];
    }
}