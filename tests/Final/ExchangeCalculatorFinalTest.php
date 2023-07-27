<?php

declare(strict_types=1);

class ExchangeCalculatorFinalTest extends \PHPUnit\Framework\TestCase
{
    private ExchangeCalculatorFinal $exchangeCalculator;

    protected function setUp(): void
    {
        $this->exchangeCalculator = new ExchangeCalculatorFinal();
    }

    /**
     * @dataProvider correctData
     */
    public function testGetPlnAmount(float $expectedResult, float $amount, string $currency): void
    {
        $this->assertEquals($expectedResult, $this->exchangeCalculator->getPlnAmount($amount, $currency));
    }

    public static function correctData(): array
    {
        return [
            'USD' => [380.0 ,100.0, 'USD'],
            'EUR' => [450.0, 100.0, 'EUR'],
        ];
    }

    public function testGetPlnAmounWrongCurrency(): void
    {
        self::expectException(\InvalidArgumentException::class);
        $this->exchangeCalculator->getPlnAmount(100, 'PLN');
    }

    public function testGetPlnAmounWrongAmount(): void
    {
        self::expectException(\InvalidArgumentException::class);
        $this->exchangeCalculator->getPlnAmount(-10, 'USD');
    }
}