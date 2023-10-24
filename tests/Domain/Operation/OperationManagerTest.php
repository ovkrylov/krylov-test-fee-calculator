<?php

namespace Krylov\CommissionTask\Tests\Domain\Operation;

use Krylov\CommissionTask\Domain\Exceptions\UndefinedOperationType;
use Krylov\CommissionTask\Domain\Exceptions\UndefinedUserType;
use Krylov\CommissionTask\Infrastructure\RamUserRepository;
use Krylov\CommissionTask\Tests\Infrastructure\ExchangeServiceMock;
use PHPUnit\Framework\TestCase;
use Krylov\CommissionTask\Domain\Operation\OperationManager;

class OperationManagerTest extends TestCase
{
    private OperationManager $om;

    public function setUp()
    {
        $this->om = new OperationManager(new ExchangeServiceMock(), new RamUserRepository());
    }

    public function testPrivateUserExceedCommissionFreeLimitAndHasPartialFee() : void
    {
        $fee = $this->om->getFee(...['2014-12-31',4,'private','withdraw',1200.00,'EUR']);
        $this->assertEquals('0.60', $fee);
    }

    public function testPrivateUserExceedCommissionFreeLimitAndHasFullFee() : void
    {
        $this->om->getFee(...['2014-12-31',4,'private','withdraw',1200.00,'EUR']);
        $fee = $this->om->getFee(...['2015-01-01',4,'private','withdraw',1000.00,'EUR']);
        $this->assertEquals('3.00', $fee);
    }

    public function testPrivateUserCommissionFreeFee() : void
    {
        $fee = $this->om->getFee(...['2016-01-05',4,'private','withdraw',1000.00,'EUR']);
        $this->assertEquals('0.00', $fee);
    }

    public function testPrivateUserCommissionFreeFeeNextWeekAfterUserExceedCommissionFreeLimit() : void
    {
        $this->om->getFee(...['2014-12-31',4,'private','withdraw',1200.00,'EUR']);
        $fee = $this->om->getFee(...['2016-01-05',4,'private','withdraw',1000.00,'EUR']);
        $this->assertEquals('0.00', $fee);
    }

    public function testPrivateDepositFee() : void
    {
        $fee = $this->om->getFee(...['2016-01-05',1,'private','deposit',200.00,'EUR']);
        $this->assertEquals('0.06', $fee);
    }

    public function testBusinessDepositFee() : void
    {
        $fee = $this->om->getFee(...['2016-01-10',2,'business','deposit',10000.00,'EUR']);
        $this->assertEquals('3.00', $fee);
    }

    public function testBusinessWithdrawFee() : void
    {
        $fee = $this->om->getFee(...['2016-01-06',2,'business','withdraw',300.00,'EUR']);
        $this->assertEquals('1.50', $fee);
    }

    public function testPrivateUserCommissionFreeFeeInOtherCurrency() : void
    {
        $fee = $this->om->getFee(...['2016-01-06',1,'private','withdraw',30000,'JPY']);
        $this->assertEquals('0', $fee);
    }

    public function testPrivateUserExceedCommissionFreeLimitAndHasPartialFeeInJPT() : void
    {
        $fee = $this->om->getFee(...['2016-02-19',5,'private','withdraw',3000000,'JPY']);
        $this->assertEquals('8612', $fee);
    }

    public function testUndefinedOperationTypeThrowsException() : void
    {
        $this->expectExceptionObject(new UndefinedOperationType('undefined'));
        $fee = $this->om->getFee(...['2016-02-19',5,'private','undefined',3000000,'JPY']);
    }

    public function testUndefinedUserTypeThrowsException() : void
    {
        $this->expectExceptionObject(new UndefinedUserType('undefined'));
        $fee = $this->om->getFee(...['2016-02-19',5,'undefined','withdraw',3000000,'JPY']);
    }
}