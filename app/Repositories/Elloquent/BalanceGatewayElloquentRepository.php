<?php namespace App\Repositories\Elloquent;

use DateTime;
use App\Models\Client;
use App\Models\Account;
use Wallet\Internal\Gateway\BalanceGateway;
use Wallet\Internal\Entity\Client\ClientEntity;
use Wallet\Internal\Entity\Account\AccountEntity;

class BalanceGatewayElloquentRepository implements BalanceGateway
{
    public function __construct(
        protected Account $account,
        protected Client $client
    ) { }

    public function getById(string $id): ?AccountEntity
    {
        $account = $this->account->where(['client_id' => $id])->first();
        $findClient = $this->client->where(['id' => $account?->client_id])->first();

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
}
