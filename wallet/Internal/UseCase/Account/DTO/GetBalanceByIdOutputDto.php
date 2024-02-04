<?php namespace Wallet\Internal\UseCase\Account\DTO;

use DateTime;
use Wallet\Internal\Entity\Client\ClientEntity;

class GetBalanceByIdOutputDto
{
    public function __construct(
        public ?string $id = null,
        public ?string $client_id = null,
        public ?ClientEntity $client = null,
        public ?float $balance = 0.0,
        public ?DateTime $created_at = null,
        public ?DateTime $updated_at = null,
    ) { }
}
