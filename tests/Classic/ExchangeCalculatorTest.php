<?php

declare(strict_types=1);

class ExchangeCalculatorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testGetPlnAmount(float $amunt, string $currency, float $expectedResult): void
    {
        $calculator = new ExchangeCalculator();
        self::assertEquals($expectedResult, $calculator->getPlnAmount($amunt, $currency));
    }

    public static function dataProvider(): array
    {
        return [
            [10, 'USD', 38],
            [0, 'EUR', 0],
        ];
    }

    public function testGetPlnAmountOnNegative(): void
    {
        self::expectException(\InvalidArgumentException::class);
        $calculator = new ExchangeCalculator();
        $calculator->getPlnAmount(-2, 'USD');
    }

    public function testGetPlnAmountOnUnsupportedCurrency(): void
    {
        self::expectException(\InvalidArgumentException::class);
        $calculator = new ExchangeCalculator();
        $calculator->getPlnAmount(10, 'PLN');
    }
}