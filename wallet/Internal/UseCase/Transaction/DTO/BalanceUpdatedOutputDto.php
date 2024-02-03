<?php namespace Wallet\Internal\UseCase\Transaction\DTO;

class BalanceUpdatedOutputDTO
{
    public function __construct(
        public ?string $id = null,
        public ?string $account_id_from = null,
        public ?string $account_id_to = null,
        public float $balance_account_id_from = 0.0,
        public float $balance_account_id_to = 0.0,
    ) { }
}
