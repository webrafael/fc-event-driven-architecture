<?php namespace Wallet\Internal\Gateway;

use Wallet\Internal\Entity\Transaction\TransactionEntity;

interface TransactionGateway
{
    public function create(TransactionEntity $transaction): TransactionEntity;
}
