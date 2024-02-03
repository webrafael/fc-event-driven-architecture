<?php namespace App\Repositories\Elloquent;

use App\Models\Transaction;
use Wallet\Internal\Gateway\TransactionGateway;
use Wallet\Internal\Entity\Transaction\TransactionEntity;

class TransactionElloquentRepository implements TransactionGateway
{
    public function __construct(protected Transaction $model)
    { }

    public function create(TransactionEntity $transaction): TransactionEntity
    {
        Transaction::create([
            'id' => $transaction->id,
            'account_id_from' => $transaction->accountFromId,
            'account_id_to' => $transaction->accountToId,
            'amount' => $transaction->amount
        ]);

        return $transaction;
    }
}
