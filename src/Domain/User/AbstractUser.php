<?php

namespace Krylov\CommissionTask\Domain\User;

use Krylov\CommissionTask\Domain\Exceptions\UndefinedOperationType;
use Krylov\CommissionTask\Domain\ProjectConfig;
use Krylov\CommissionTask\Domain\ServiceConfig;
use Krylov\CommissionTask\Domain\Operation\OperationInterface;

/**
 * AbstractUser describes functionality for abstract user
 */
abstract class AbstractUser implements UserInterface
{
    /** @var int $id - user id */
    protected int $id;

    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * Implements deposit operation for all types of users and returns operation fee
     *
     * @param OperationInterface $order
     * @return float|int
     */
    public function deposit(OperationInterface $order) : float
    {
        return $this->getFee(
            ProjectConfig::DEPOSIT_FEE,
            $order->getAmount()->getValue(),
            $order->getAmount()->getCurrency()
        );
    }

    /**
     * Returns fee for feeable value rounded to correspond to currency decimal value
     *
     * @param $fee
     * @param $amount
     * @param $currency
     * @return float|int
     */
    protected function getFee($fee, $amount, $currency) : string
    {
        switch ($currency === 'JPY') {
            case 'JPY':
                return sprintf("%d\n", ceil($fee / 100 * $amount));
            default:
                return sprintf("%0.2f\n", ceil($fee * $amount) / 100);
        }
    }

    /**
     * Rounds up value to second decimal
     *
     * @param $value
     * @return float|int
     */
    protected function round2Decimals($value) {
        return ceil($value * 100) / 100;
    }

    /**
     * @param OperationInterface $operation
     * @return float
     */
    public function getOperationFee(OperationInterface $operation) : float
    {
        switch (get_class($operation)) {
            case ServiceConfig::DEPOSIT_OPERATION_CLASS:
                $fee = $this->deposit($operation);
                break;
            case ServiceConfig::WITHDRAW_OPERATION_CLASS:
                $fee = $this->withdraw($operation);
                break;
            default:
                throw new UndefinedOperationType(get_class($operation));
        }
        return $fee;
    }
}
