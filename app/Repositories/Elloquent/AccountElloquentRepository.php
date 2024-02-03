<?php namespace App\Repositories\Elloquent;

use App\Models\Account;
use App\Models\Client;
use DateTime;
use Wallet\Internal\Gateway\AccountGateway;
use Wallet\Internal\Entity\Client\ClientEntity;
use Wallet\Internal\Entity\Account\AccountEntity;
use Wallet\Internal\Gateway\Exception\InvalidRepositoryException;

class AccountElloquentRepository implements AccountGateway
{
    public function __construct(
        protected Account $account,
        protected Client $client
    ) { }

    public function save(AccountEntity $account): AccountEntity
    {
        try {
            Account::create([
                'id' => $account->id,
                'client_id' => $account->clientId,
                'balance' => $account->balance,
            ]);

            return $account;

        } catch(\Exception $exc) {
            throw new InvalidRepositoryException($exc->getMessage(), 400);
        }
    }

    public function findById(string $id): ?AccountEntity
    {
        $client  = null;
        $account = $this->account->where(['id' => $id])->first();
        $findClient = $this->client->where(['id' => $account->client_id])->first();

        if ($account && $findClient) {
            $client = new ClientEntity(
                id: $findClient?->id,
                name: $findClient?->name,
                email: $findClient?->email,
                createdAt: new DateTime($findClient?->created_at),
                updatedAt: new DateTime($findClient?->updated_at),
            );
        }

        if ($account) {
            return new AccountEntity(
                id: $account->index,
                client: $client,
                clientId: $account->client_id,
                balance: $account->balance,
                createdAt: new DateTime($account->created_at),
                updatedAt: new DateTime($account->updated_at)
            );
        }

        return null;
    }

    public function updateBalance(AccountEntity $account): AccountEntity
    {
        $findAccount = $this->account->where(['client_id' => $account->clientId])->first();

        if (! is_null($findAccount)) {
            $findAccount->balance = $account->balance;
            $findAccount->updated_at = $account->updatedAt->format("Y-m-d H:i:s");
            $findAccount->save();
        }

        return $account;
    }
}
