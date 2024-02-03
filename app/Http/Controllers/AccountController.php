<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\Account;
use Wallet\Internal\UseCase\Account\CreateAccountUseCase;
use Wallet\Internal\UseCase\Account\DTO\CreateAccountInputDto;

class AccountController extends Controller
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
    public function store(StoreAccountRequest $request, CreateAccountUseCase $usecase)
    {
        try {
            $execute = $usecase->execute(new CreateAccountInputDto(
                client_id: $request->client_id
            ));

            return response()->json($execute);

        } catch (\Exception $exc) {
            return response()->json($exc->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        //
    }
}
