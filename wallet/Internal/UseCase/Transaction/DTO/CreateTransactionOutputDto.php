<?php namespace Wallet\Internal\UseCase\Transaction\DTO;

class CreateTransactionOutputDTO
{
    public function __construct(
        public ?string $id = null,
        public ?string $account_id_from = null,
        public ?string $account_id_to = null,
        public float $amount = 0.0
    ) { }
}
