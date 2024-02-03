<?php namespace Wallet\Internal\Gateway;

use Wallet\Internal\Entity\Client\ClientEntity;

interface ClientGateway
{
    public function get(string $id): ClientEntity;
    public function save(ClientEntity $client): ClientEntity;
}
