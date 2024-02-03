<?php

namespace Tests\Unit;

use DateTime;
use PHPUnit\Framework\TestCase;
use Wallet\Internal\Entity\Client\ClientEntity;
use Wallet\Internal\Entity\Account\AccountEntity;
use Wallet\Internal\Entity\Transaction\TransactionEntity;
use Wallet\Internal\Entity\Exception\InvalidEntityException;

class TransactionTest extends TestCase
{
    public function test_create_new_transaction()
    {

        $transaction = new TransactionEntity(
            id: 'id-transaction',
            accountFrom: new AccountEntity(
                id: 'id-from-account',
                client: new ClientEntity(
                    id: 'id-from-client',
                    name: 'Rob',
                    email: 'rob@r.com',
                    createdAt: new DateTime('now')
                ),
                clientId: 'id-from-client',
                balance: 1000,
                createdAt: new DateTime('now')
            ),
            accountFromId: 'id-from',
            accountTo: new AccountEntity(
                id: 'id-to-account',
                client: new ClientEntity(
                    id: 'id-to-client',
                    name: 'Xica',
                    email: 'Xica@x.com',
                    createdAt: new DateTime('now')
                ),
                clientId: 'id-to-client',
                balance: 50,
                createdAt: new DateTime('now')
            ),
            accountToId: 'id-to',
            amount: 20,
            createdAt: new DateTime('now')
        );

        $this->assertEquals('id-transaction', $transaction->id);
        $this->assertEquals('id-from', $transaction->accountFromId);
        $this->assertEquals('id-to', $transaction->accountToId);
        $this->assertEquals(20, $transaction->amount);
        $this->assertEquals(980, $transaction->debitFromAccount());
        $this->assertInstanceOf(TransactionEntity::class, $transaction);
    }

    public function test_create_new_insuficient_transaction()
    {
        $this->expectException(InvalidEntityException::class);

        $transaction = new TransactionEntity(
            id: 'id-transaction',
            accountFrom: new AccountEntity(
                id: 'id-from-account',
                client: new ClientEntity(
                    id: 'id-from-client',
                    name: 'Rob',
                    email: 'rob@r.com',
                    createdAt: new DateTime('now')
                ),
                clientId: 'id-from-client',
                balance: 5,
                createdAt: new DateTime('now')
            ),
            accountFromId: 'id-from',
            accountTo: new AccountEntity(
                id: 'id-to-account',
                client: new ClientEntity(
                    id: 'id-to-client',
                    name: 'Xica',
                    email: 'Xica@x.com',
                    createdAt: new DateTime('now')
                ),
                clientId: 'id-to-client',
                balance: 50,
                createdAt: new DateTime('now')
            ),
            accountToId: 'id-to',
            amount: 20,
            createdAt: new DateTime('now')
        );

        $this->assertEquals('id-transaction', $transaction->id);
        $this->assertEquals('id-from', $transaction->accountFromId);
        $this->assertEquals('id-to', $transaction->accountToId);
        $this->assertEquals(20, $transaction->amount);
        $this->assertInstanceOf(TransactionEntity::class, $transaction);
    }
}
