<?php

namespace Krylov\CommissionTask\Domain\Operation;

use Krylov\CommissionTask\Domain\User\UserInterface;

/**
 * Interface for any operations
 */
interface OperationInterface
{
    public function calculateFee() : string;
    public function getAmount() : Amount;
    public function getWeek() : int;
    public function getUser() : UserInterface;
}