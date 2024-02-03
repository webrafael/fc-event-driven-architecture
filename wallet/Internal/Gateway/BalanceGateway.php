<?php namespace Wallet\Internal\Gateway;

use Wallet\Internal\Entity\Account\AccountEntity;

interface BalanceGateway
{
    public function getById(string $id): ?AccountEntity;
}
