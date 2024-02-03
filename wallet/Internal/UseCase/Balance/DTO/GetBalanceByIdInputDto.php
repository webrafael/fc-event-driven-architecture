<?php namespace Wallet\Internal\UseCase\Balance\DTO;

class GetBalanceByIdInputDto
{
    public function __construct(
        public ?string $id = null
    ) { }
}
