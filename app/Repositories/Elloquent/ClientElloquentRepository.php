<?php namespace App\Repositories\Elloquent;

use App\Models\Client;
use DateTime;
use Wallet\Internal\Gateway\ClientGateway;
use Wallet\Internal\Entity\Client\ClientEntity;

class ClientElloquentRepository implements ClientGateway
{
    public function __construct(protected Client $model)
    { }

    public function get(string $id): ?ClientEntity
    {
        $client = $this->model->where(['id' => $id])->first();

        if (! is_null($client)) {
            return new ClientEntity(
                id: $client->id,
                name: $client->name,
                email: $client->email,
                createdAt: $client->createdAt,
                updatedAt: $client->updatedAt,
            );
        }

        return null;
    }

    public function save(ClientEntity $client): ClientEntity
    {
        $create = Client::create([
            'id' => $client->id,
            'name' => $client->name,
            'email' => $client->email,
        ]);

        return new ClientEntity(
            id: $create->id,
            name: $client->name,
            email: $client->email,
            createdAt: new DateTime($create->created_at),
            updatedAt: new DateTime($create->updated_at),
        );
    }
}
