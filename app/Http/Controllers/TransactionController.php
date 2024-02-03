<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Wallet\Internal\Event\BalanceUpdated;
use Wallet\Internal\Event\TransactionCreated;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use Wallet\Internal\UseCase\Transaction\CreateTransactionUseCase;
use Wallet\Internal\UseCase\Transaction\DTO\CreateTransactionInputDto;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json('ok');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request, CreateTransactionUseCase $usecase)
    {
        try {
            $exec = $usecase->withEvents(
                new BalanceUpdated('BalanceUpdated'),
                new TransactionCreated('TransactionCreated')
            )
            ->execute(new CreateTransactionInputDto(
                account_id_from: $request->account_id_from,
                account_id_to: $request->account_id_to,
                amount: $request->amount,
            ));

            return response()->json($exec);

        } catch(\Exception $exc) {
            return response()->json($exc->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
