<?php namespace Wallet\Internal\UseCase\Client;

use DateTime;
use Ramsey\Uuid\Uuid;
use Wallet\Internal\Entity\Client\ClientEntity;
use Wallet\Internal\Gateway\ClientGateway;
use Wallet\Internal\UseCase\Client\DTO\CreateClientInputDto;
use Wallet\Internal\UseCase\Client\DTO\CreateClientOutputDto;

class CreateClientUseCase
{
    public function __construct(
        protected ClientGateway $clientGateway
    ) { }

    public function execute(CreateClientInputDto $input): CreateClientOutputDto
    {
        $repository = $this->clientGateway->save(new ClientEntity(
            id: Uuid::uuid4(),
            name: $input->name,
            email: $input->email,
            createdAt: new DateTime('now'),
        ));

        $output = new CreateClientOutputDto(
            name: $repository->name,
            email: $repository->email,
            createdAt: $repository->createdAt,
            updatedAt: $repository->updatedAt,
        );

        return $output;
    }
}
