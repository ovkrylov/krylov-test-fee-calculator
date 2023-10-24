<?php

namespace Krylov\CommissionTask\Infrastructure;

use Krylov\CommissionTask\Domain\Exceptions\UndefinedUserType;
use Krylov\CommissionTask\Domain\ProjectConfig;
use Krylov\CommissionTask\Domain\ServiceConfig;
use Krylov\CommissionTask\Domain\User\UserInterface;
use Krylov\CommissionTask\Domain\User\UserRepositoryInterface;

/**
 * UserManager class defines all operations with user
 */
class RamUserRepository implements UserRepositoryInterface
{
    private array $users = [];

    /**
     * Creates new user, stores it in memory and return
     *
     * @param int $id
     * @param string $typeName
     * @return UserInterface
     * @throws UndefinedUserType
     */
    public function create(int $id, string $typeName) : UserInterface
    {
        switch ($typeName) {
            case ProjectConfig::PRIVATE_USER_TYPE_NAME:
                $className = ServiceConfig::PRIVATE_USER_TYPE_CLASS;
                break;
            case ProjectConfig::BUSINESS_USER_TYPE_NAME:
                $className = ServiceConfig::BUSINESS_USER_TYPE_CLASS;
                break;
            default:
                throw new UndefinedUserType($typeName);
        }
        $this->users[$id] = new $className($id);
        return $this->users[$id];
    }

    /**
     * Returns user by id or null if not found
     *
     * @param int $id
     * @return UserInterface|null
     */
    public function findById(int $id): ?UserInterface
    {
        return $this->users[$id] ?? null;
    }
}