<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Wallet\Internal\UseCase\Balance\GetBalanceByIdUseCase;
use Wallet\Internal\UseCase\Balance\DTO\GetBalanceByIdInputDto;

class BalanceController extends Controller
{
    public function get($account_id = null, GetBalanceByIdUseCase $usecase)
    {
        $execute = $usecase->execute(new GetBalanceByIdInputDto(
            $account_id
        ));

        return response()->json($execute);
    }
}
