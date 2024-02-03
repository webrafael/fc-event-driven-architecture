<?php namespace Wallet\Internal\UseCase\Account;


use DateTime;
use Ramsey\Uuid\Uuid;
use Wallet\Internal\Gateway\ClientGateway;
use Wallet\Internal\Gateway\AccountGateway;
use Wallet\Internal\Entity\Account\AccountEntity;
use Wallet\Internal\UseCase\Account\DTO\CreateAccountInputDto;
use Wallet\Internal\UseCase\Exception\InvalidUseCaseException;
use Wallet\Internal\Gateway\Transaction\DBTransactionInterface;
use Wallet\Internal\UseCase\Account\DTO\CreateAccountOutputDto;

class CreateAccountUseCase
{
    public function __construct(
        protected AccountGateway $accountGateway,
        protected ClientGateway $clientGateway,
        protected DBTransactionInterface $transaction
    ) { }

    public function execute(CreateAccountInputDto $input): CreateAccountOutputDto
    {
        try {
            $client = $this->clientGateway->get($input->client_id);

            if (! $client) {
                throw new InvalidUseCaseException("Client not found");
            }

            $repository = $this->accountGateway->save(new AccountEntity(
                id: Uuid::uuid4(),
                client: $client,
                clientId: $client->id,
                balance: 0,
                createdAt: new DateTime('now'),
                updatedAt: null
            ));

            $this->transaction->commit();

            $output = new CreateAccountOutputDto(
                id: $repository->id
            );

            return $output;
        } catch(\Exception $exc) {
            $this->transaction->rollback();
            throw new InvalidUseCaseException($exc->getMessage());
        }
    }
}
