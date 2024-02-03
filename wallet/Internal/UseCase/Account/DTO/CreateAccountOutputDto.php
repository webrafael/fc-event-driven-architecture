<?php namespace Wallet\Internal\UseCase\Account\DTO;

class CreateAccountOutputDto
{
    public function __construct(
        public ?string $id = null,
    ) { }
}
