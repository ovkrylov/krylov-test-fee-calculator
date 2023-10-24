#!/usr/bin/env php
<?php

declare(strict_types=1);
include __DIR__ . '/vendor/autoload.php';

use Krylov\CommissionTask\Domain\Operation\OperationManager;
use Krylov\CommissionTask\Infrastructure\RamUserRepository;
use Krylov\CommissionTask\Infrastructure\WebExchangeService;

$orderManager = new OperationManager(new WebExchangeService(), new RamUserRepository());
if (($handle = fopen($argv[1], 'rb')) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if($data[5] === 'JPY') {
            $format = "%d\n";
        } else {
            $format = "%0.2f\n";
        }
        echo sprintf($format, $orderManager->getFee(...$data));
    }
    fclose($handle);
}