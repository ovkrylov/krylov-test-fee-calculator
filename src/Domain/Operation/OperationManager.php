<?php

namespace Krylov\CommissionTask\Domain\Operation;

use Exception;
use Krylov\CommissionTask\Domain\Exceptions\UndefinedOperationType;
use Krylov\CommissionTask\Domain\ExchangeServiceInterface;
use Krylov\CommissionTask\Domain\ProjectConfig;
use Krylov\CommissionTask\Domain\ServiceConfig;
use Krylov\CommissionTask\Domain\User\UserRepositoryInterface;

/**
 * OperationManager handles all operations
 */
class OperationManager
{
    /** @var UserRepositoryInterface $userRepo*/
    private UserRepositoryInterface $userRepo;

    /** @var ExchangeServiceInterface $exchangeService */
    private ExchangeServiceInterface $exchangeService;

    /**
     * @param ExchangeServiceInterface $exchangeService
     * @param UserRepositoryInterface $userRepo
     */
    public function __construct(ExchangeServiceInterface $exchangeService, UserRepositoryInterface $userRepo)
    {
        $this->exchangeService = $exchangeService;
        $this->userRepo = $userRepo;
    }

    /**
     * Returns fee for operation
     *
     * @param $dateString
     * @param $userId
     * @param $userType
     * @param $operationType
     * @param $value
     * @param $currency
     * @return string
     * @throws Exception
     * @throws UndefinedOperationType
     */
    public function getFee($dateString, $userId, $userType, $operationType, $value, $currency) : string
    {
        $exchangeRate = $this->exchangeService->getRate($currency);
        $amount = new Amount($value, $currency, $exchangeRate);
        switch ($operationType) {
            case ProjectConfig::DEPOSIT_OPERATION_NAME:
                $operationClass = ServiceConfig::DEPOSIT_OPERATION_CLASS;
                break;
            case ProjectConfig::WITHDRAW_OPERATION_NAME:
                $operationClass = ServiceConfig::WITHDRAW_OPERATION_CLASS;
                break;
            default:
                throw new UndefinedOperationType($operationType);
        }
        $user = $this->userRepo->findById($userId) ?? $this->userRepo->create($userId, $userType);
        return (new $operationClass(
            new \DateTime($dateString),
            $user,
            $amount))->calculateFee();
    }
}