<?php

namespace Krylov\CommissionTask\Domain\User;

use Krylov\CommissionTask\Domain\ProjectConfig;
use Krylov\CommissionTask\Domain\Operation\OperationInterface;

/**
 * BusinessUser specifies business client operations logic
 */
class BusinessUser extends AbstractUser
{
    private const WITHDRAW_FEE = ProjectConfig::BUSINESS_WITHDRAW_FEE;

    /**
     * @param OperationInterface $order
     * @return float|int
     */
    public function withdraw(OperationInterface $order)
    {
        return $this->getFee(
            self::WITHDRAW_FEE,
            $order->getAmount()->getValue(),
            $order->getAmount()->getCurrency()
        );
    }
}