<?php

namespace Krylov\CommissionTask\Domain\Operation;

use Krylov\CommissionTask\Domain\User\UserInterface;

/**
 * AbstractOperation class defines operation and holds pointers to user, amount
 */
abstract class AbstractOperation implements OperationInterface
{
    /** @var UserInterface $user */
    private UserInterface $user;

    /** @var Amount $amount */
    private Amount $amount;

    /** @var \DateTime $date */
    private \DateTime $date;

    /**
     * @param \DateTime $date
     * @param UserInterface $user
     * @param Amount $amount
     */
    public function __construct(\DateTime $date, UserInterface $user, Amount $amount)
    {
        $this->date = $date;
        $this->user = $user;
        $this->amount = $amount;
    }

    /**
     * @return Amount
     */
    public function getAmount() : Amount
    {
        return $this->amount;
    }

    /**
     * Returns numeric representation of date of operation
     *
     * @return int
     */
    public function getWeek() : int
    {
        return floor(((int)$this->date->format('U') + 259200 )/ (60 * 60 * 24 * 7));
    }

    /**
     * @return UserInterface
     */
    public function getUser() : UserInterface
    {
        return $this->user;
    }

    /**
     * @return \DateTime
     */
    public function getDate() : \DateTime
    {
        return $this->date;
    }

    /**
     * Returns operation fee
     *
     * @return string
     */
    public function calculateFee(): string
    {
        return $this->getUser()->getOperationFee($this);
    }
}