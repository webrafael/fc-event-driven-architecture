<?php namespace Wallet\Internal\UseCase\Client;

use DateTime;
use Ramsey\Uuid\Uuid;
use Wallet\Internal\Gateway\ClientGateway;
use Wallet\Internal\Entity\Client\ClientEntity;
use Wallet\Internal\UseCase\Client\DTO\CreateClientInputDto;
use Wallet\Internal\UseCase\Client\DTO\CreateClientOutputDto;
use Wallet\Internal\Gateway\Transaction\DBTransactionInterface;
use Wallet\Internal\UseCase\Exception\InvalidUseCaseException;

class CreateClientUseCase
{
    public function __construct(
        protected ClientGateway $clientGateway,
        protected DBTransactionInterface $transaction
    ) { }

    public function execute(CreateClientInputDto $input): CreateClientOutputDto
    {
        try {
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

            $this->transaction->commit();

            return $output;
        } catch (\Exception $exc) {
            $this->transaction->rollback();
            throw new InvalidUseCaseException($exc->getMessage());
        }
    }
}
