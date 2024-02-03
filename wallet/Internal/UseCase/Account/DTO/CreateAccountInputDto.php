<?php namespace Wallet\Internal\UseCase\Account\DTO;

class CreateAccountInputDto
{
    public function __construct(
        public ?string $client_id = null
    ) { }
}
