<?php

namespace Krylov\CommissionTask\Infrastructure\Exceptions;

class ExchangeServiceConnectionFailed extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Exchange service connection failed', 0, null);
    }
}