<?php namespace Wallet\Internal\UseCase\Client\DTO;

class CreateClientInputDto
{
    public function __construct(
        public ?string $name = null,
        public ?string $email = null,
    ) { }
}
