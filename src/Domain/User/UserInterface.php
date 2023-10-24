<?php

namespace Krylov\CommissionTask\Domain\User;

use Krylov\CommissionTask\Domain\Operation\OperationInterface;

/**
 * Interface for users
 */
interface UserInterface
{
    /**
     * Returns operation fee for current user
     *
     * @param OperationInterface $operation
     * @return float
     */
    public function getOperationFee(OperationInterface $operation) : float;
}