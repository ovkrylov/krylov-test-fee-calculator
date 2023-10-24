<?php

namespace Krylov\CommissionTask\Infrastructure;

use Krylov\CommissionTask\Domain\ExchangeServiceInterface;
use Krylov\CommissionTask\Domain\ProjectConfig;
use Krylov\CommissionTask\Infrastructure\Exceptions\ExchangeServiceConnectionFailed;

/**
 * Connector to exchange rate service API
 */
class WebExchangeService implements ExchangeServiceInterface
{
    private const EXCHANGE_RATE_URL = ProjectConfig::EXCHANGE_RATE_URL;
    private array $rates;

    public function __construct()
    {
        try {
            $this->rates = @json_decode(
                file_get_contents(self::EXCHANGE_RATE_URL),
                true,
                512,
                JSON_THROW_ON_ERROR
            )['rates'];
        } catch (\JsonException $e) {
            throw new ExchangeServiceConnectionFailed();
        }
    }

    /**
     * Returns exchange rate to EUR for defined currency
     *
     * @param string $currency
     * @return float
     */
    public function getRate(string $currency) : float
    {
        return $this->rates[$currency];
    }
}