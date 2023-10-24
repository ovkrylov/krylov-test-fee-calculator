<?php

namespace Krylov\CommissionTask\Domain;

/**
 * Stores project related or business logic constants
 */
class ProjectConfig
{
    public const DEPOSIT_FEE = 0.03;
    public const BUSINESS_WITHDRAW_FEE = 0.5;
    public const PRIVATE_WITHDRAW_FEE = 0.3;

    public const DEPOSIT_OPERATION_NAME = 'deposit';
    public const WITHDRAW_OPERATION_NAME = 'withdraw';

    public const PRIVATE_USER_TYPE_NAME = 'private';
    public const BUSINESS_USER_TYPE_NAME = 'business';

    public const PRIVATE_USER_FREE_OPERATIONS_PER_WEEK_NUM = 3;
    public const PRIVATE_USER_FREE_EU_AMOUNT_PER_WEEK_NUM = 1000.00;

    public const EXCHANGE_RATE_URL = 'https://developers.paysera.com/tasks/api/currency-exchange-rates';
}