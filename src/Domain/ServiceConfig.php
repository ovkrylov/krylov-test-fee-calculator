<?php

namespace Krylov\CommissionTask\Domain;

use Krylov\CommissionTask\Domain\Operation\DepositOperation;
use Krylov\CommissionTask\Domain\Operation\WithdrawOperation;
use Krylov\CommissionTask\Domain\User\BusinessUser;
use Krylov\CommissionTask\Domain\User\PrivateUser;

/**
 * Stores service related constants
 */
class ServiceConfig
{
    public const DEPOSIT_OPERATION_CLASS = DepositOperation::class;
    public const WITHDRAW_OPERATION_CLASS = WithdrawOperation::class;
    public const PRIVATE_USER_TYPE_CLASS = PrivateUser::class;
    public const BUSINESS_USER_TYPE_CLASS = BusinessUser::class;
}