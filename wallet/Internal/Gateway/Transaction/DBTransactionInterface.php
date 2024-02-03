<?php namespace Wallet\Internal\Gateway\Transaction;

interface DBTransactionInterface
{
    public function commit();

    public function rollback();
}
