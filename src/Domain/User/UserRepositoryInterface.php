<?php

namespace Krylov\CommissionTask\Domain\User;

interface UserRepositoryInterface
{
    public function create(int $id, string $typeName) : UserInterface;
    public function findById(int $id) : ?UserInterface;
}