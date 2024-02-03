<?php namespace Wallet\Internal\UseCase\Client\DTO;

use DateTime;

class CreateClientOutputDto
{
    public function __construct(
        public ?string $name = null,
        public ?string $email = null,
        public ?DateTime $createdAt = null,
        public ?DateTime $updatedAt = null
    ) { }
}
