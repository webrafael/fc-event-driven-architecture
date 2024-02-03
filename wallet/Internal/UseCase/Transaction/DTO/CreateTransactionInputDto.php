<?php namespace Wallet\Internal\UseCase\Transaction\DTO;

class CreateTransactionInputDto
{
    public function __construct(
        public ?string $account_id_from = null,
        public ?string $account_id_to = null,
        public float $amount = 0.0
    ) { }
}
