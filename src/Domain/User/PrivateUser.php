<?php

namespace Krylov\CommissionTask\Domain\User;

use Krylov\CommissionTask\Domain\ProjectConfig;
use Krylov\CommissionTask\Domain\Operation\OperationInterface;

/**
 * PrivateUser specifies private client operations logic
 */
class PrivateUser extends AbstractUser
{
    private const WITHDRAW_FEE = ProjectConfig::PRIVATE_WITHDRAW_FEE;
    private const FREE_OPERATIONS_PER_WEEK_NUM = ProjectConfig::PRIVATE_USER_FREE_OPERATIONS_PER_WEEK_NUM;
    private const FREE_EU_AMOUNT_PER_WEEK_NUM = ProjectConfig::PRIVATE_USER_FREE_EU_AMOUNT_PER_WEEK_NUM;

    private int $week = 0;
    private float $valueLeft;
    private int $operationsLeft;

    /**
     * @param OperationInterface $order
     * @return float|int
     */
    public function withdraw(OperationInterface $order)
    {
        // set whole amount as feeable if no other rules works
        $feebleAmount = $order->getAmount()->getValue();

        // if current order get different week number we should clear commission free rules
        if ($order->getWeek() !== $this->week) {
            $this->valueLeft = self::FREE_EU_AMOUNT_PER_WEEK_NUM;
            $this->operationsLeft = self::FREE_OPERATIONS_PER_WEEK_NUM;
            $this->week = $order->getWeek();
        }

        // get EUR value for operation
        $euValue = $this->round2Decimals($order->getAmount()->getValue() / $order->getAmount()->getExchangeRate());
        $this->valueLeft -= $euValue; // if this value will be negative then commission free limit exceeded
        $this->operationsLeft--; // use one of commission free operations

        if ($this->operationsLeft >= 0) { // check commission free operation limit
            if($this->valueLeft < 0) { // check commission free vale limit
                // commission is calculated only for the exceeded amount (in correspond currency)
                $feebleAmount = abs($this->valueLeft) * $order->getAmount()->getExchangeRate();
                $this->valueLeft = 0; // set commission free vale limit to 0
            } else {
                $feebleAmount = 0; // commission free operation. no limits exceeded
            }
        }
        return $this->getFee(self::WITHDRAW_FEE, $feebleAmount, $order->getAmount()->getCurrency());
    }
}