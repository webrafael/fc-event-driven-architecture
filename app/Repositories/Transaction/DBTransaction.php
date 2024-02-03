<?php namespace App\Repositories\Transaction;

use Illuminate\Support\Facades\DB;
use Wallet\Internal\Gateway\Transaction\DBTransactionInterface;

class DBTransaction implements DBTransactionInterface
{
    public function __construct()
    {
        DB::beginTransaction();
    }

    public function commit()
    {
        DB::commit();
    }

    public function rollback()
    {
        DB::rollBack();
    }
}
