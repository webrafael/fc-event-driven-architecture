<?php

namespace Tests\Unit;

use DateTime;
use PHPUnit\Framework\TestCase;
use Wallet\Internal\Entity\Client\ClientEntity;
use Wallet\Internal\Entity\Account\AccountEntity;
use Wallet\Internal\Entity\Exception\InvalidEntityException;

class AccountTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_create_new_account(): void
    {
        $account = new AccountEntity(
            id: 'id-1',
            client: new ClientEntity(
                id: 'id-client',
                name: 'Nome do cliente',
                email: 'client@test.com',
                createdAt: new DateTime('now'),
                updatedAt: null,
            ),
            clientId: 'client-id',
            balance: 125.0,
            createdAt: new DateTime('now'),
            updatedAt: null
        );

        $this->assertEquals('id-1', $account->id);
        $this->assertEquals(125.0, $account->balance);
        $this->assertEquals('client-id', $account->clientId);
        $this->isNull($account->updatedAt);

        $this->assertInstanceOf(AccountEntity::class, $account);
        $this->assertInstanceOf(ClientEntity::class, $account->client);
        $this->assertInstanceOf(DateTime::class, $account->createdAt);
    }

    public function test_credit_account()
    {
        $account = new AccountEntity(
            id: 'id-1',
            client: new ClientEntity(
                id: 'id-client',
                name: 'Nome do cliente',
                email: 'client@test.com',
                createdAt: new DateTime('now'),
                updatedAt: null,
            ),
            clientId: 'client-id',
            balance: 125,
            createdAt: new DateTime('now'),
            updatedAt: null
        );

        $account->credit(30);

        $this->assertEquals(155, $account->balance);
    }

    public function test_debit_account()
    {
        $account = new AccountEntity(
            id: 'id-1',
            client: new ClientEntity(
                id: 'id-client',
                name: 'Nome do cliente',
                email: 'client@test.com',
                createdAt: new DateTime('now'),
                updatedAt: null,
            ),
            clientId: 'client-id',
            balance: 125,
            createdAt: new DateTime('now'),
            updatedAt: null
        );

        $account->debit(30);

        $this->assertEquals(95, $account->balance);
    }

    public function test_insuficient_founds_debit_account()
    {
        $account = new AccountEntity(
            id: 'id-1',
            client: new ClientEntity(
                id: 'id-client',
                name: 'Nome do cliente',
                email: 'client@test.com',
                createdAt: new DateTime('now'),
                updatedAt: null,
            ),
            clientId: 'client-id',
            balance: 125,
            createdAt: new DateTime('now'),
            updatedAt: null
        );

        $this->expectException(InvalidEntityException::class);

        $account->debit(999);
    }
}
