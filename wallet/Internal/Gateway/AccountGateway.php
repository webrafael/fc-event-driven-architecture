<?php namespace Wallet\Internal\Gateway;

use Wallet\Internal\Entity\Account\AccountEntity;

interface AccountGateway
{
    public function save(AccountEntity $account): AccountEntity;
    public function findById(string $id): ?AccountEntity;
    public function updateBalance(AccountEntity $account): ?AccountEntity;
}
