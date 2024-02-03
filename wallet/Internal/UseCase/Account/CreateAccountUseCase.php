<?php namespace Wallet\Internal\UseCase\Account;

use DateTime;
use Ramsey\Uuid\Uuid;
use Wallet\Internal\Entity\Account\AccountEntity;
use Wallet\Internal\Gateway\AccountGateway;
use Wallet\Internal\Gateway\ClientGateway;
use Wallet\Internal\UseCase\Account\DTO\CreateAccountInputDto;
use Wallet\Internal\UseCase\Account\DTO\CreateAccountOutputDto;

class CreateAccountUseCase
{
    public function __construct(
        protected AccountGateway $accountGateway,
        protected ClientGateway $clientGateway,
    ) { }

    public function execute(CreateAccountInputDto $input): CreateAccountOutputDto
    {
        $client = $this->clientGateway->get($input->client_id);

        $repository = $this->accountGateway->save(new AccountEntity(
            id: Uuid::uuid4(),
            client: $client,
            clientId: $client->id,
            balance: 0,
            createdAt: new DateTime('now'),
            updatedAt: null
        ));

        $output = new CreateAccountOutputDto(
            id: $repository->id
        );

        return $output;
    }
}
