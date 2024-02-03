<?php

namespace Tests\Unit;

use DateTime;
use PHPUnit\Framework\TestCase;
use Wallet\Internal\Entity\Client\ClientEntity;
use Wallet\Internal\Entity\Exception\InvalidEntityException;

class ClientTest extends TestCase
{
    public function test_create_new_client()
    {
        $client = new ClientEntity(
            id: 'id-client',
            name: 'Rob',
            email: 'rob@r.com',
            createdAt: new DateTime('now'),
            updatedAt: null,
        );

        $this->assertEquals('id-client', $client->id);
        $this->assertEquals('Rob', $client->name);
        $this->assertEquals('rob@r.com', $client->email);
        $this->assertInstanceOf(ClientEntity::class, $client);
        $this->isNull($client->updatedAt);
    }

    public function test_create_new_invalid_name_client()
    {
        $this->expectException(InvalidEntityException::class);

        $client = new ClientEntity(
            id: 'id-client',
            name: '',
            email: 'rob@r.com',
            createdAt: new DateTime('now'),
            updatedAt: null,
        );

        $this->assertEquals('id-client', $client->id);
        $this->assertEquals('', $client->name);
        $this->assertEquals('rob@r.com', $client->email);
        $this->assertInstanceOf(ClientEntity::class, $client);
        $this->isNull($client->updatedAt);
    }

    public function test_create_new_invalid_email_client()
    {
        $this->expectException(InvalidEntityException::class);

        $client = new ClientEntity(
            id: 'id-client',
            name: 'Rob',
            email: '',
            createdAt: new DateTime('now'),
            updatedAt: null,
        );

        $this->assertEquals('id-client', $client->id);
        $this->assertEquals('Rob', $client->name);
        $this->assertEquals('', $client->email);
        $this->assertInstanceOf(ClientEntity::class, $client);
        $this->isNull($client->updatedAt);
    }
}
