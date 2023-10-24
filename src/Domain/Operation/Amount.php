<?php
declare(strict_types=1);

namespace Krylov\CommissionTask\Domain\Operation;

/**
 * Amount is a class for storing operation values such as number, currency and current exchange rate to EUR
 */
final class Amount
{
    /** @var float $value */
    private float $value;

    /** @var string $currency */
    private string $currency;

    /** @var float $exchangeRate */
    private float $exchangeRate;

    /**
     * @param float $value
     * @param string $currency
     * @param float $exchangeRate
     */
    public function __construct(float $value, string $currency, float $exchangeRate) {
        $this->currency = $currency;
        $this->value = $value;
        $this->exchangeRate = $exchangeRate;
    }

    /**
     * @return float
     */
    public function getExchangeRate() : float
    {
        return $this->exchangeRate;
    }

    /**
     * @return float
     */
    public function getValue() : float {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getCurrency() : string {
        return $this->currency;
    }
}