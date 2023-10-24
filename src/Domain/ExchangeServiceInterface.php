<?php

namespace Krylov\CommissionTask\Domain;

interface ExchangeServiceInterface
{
    public function getRate(string $currency) : float;
}