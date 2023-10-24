<?php

namespace Krylov\CommissionTask\Domain\Exceptions;

class UndefinedOperationType extends \RuntimeException
{
    public function __construct(string $type)
    {
        parent::__construct("$type operation undefined.");
    }
}