<?php

namespace Krylov\CommissionTask\Tests\Infrastructure;

use Krylov\CommissionTask\Domain\ExchangeServiceInterface;

class ExchangeServiceMock implements ExchangeServiceInterface
{
    public function getRate(string $currency): float
    {
        return $this->rates[$currency];
    }

    private array $rates = [
        "EUR" => 1,
        "JPY" => 129.53,
        "USD" => 1.1497,
    ];
}