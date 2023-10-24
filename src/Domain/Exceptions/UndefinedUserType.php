<?php

namespace Krylov\CommissionTask\Domain\Exceptions;

class UndefinedUserType extends \RuntimeException
{
    public function __construct(string $type)
    {
        parent::__construct("$type type for user not found.", 404, null);
    }
}