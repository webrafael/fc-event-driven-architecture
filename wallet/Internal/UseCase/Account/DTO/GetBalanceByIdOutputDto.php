<?php namespace Wallet\Internal\UseCase\Account\DTO;

use DateTime;

class GetBalanceByIdOutputDto
{
    public function __construct(
        public ?string $id = null,
        public ?string $client_id = null,
        public ?float $balance = 0.0,
        public ?DateTime $created_at = null,
        public ?DateTime $updated_at = null,
    ) { }
}
