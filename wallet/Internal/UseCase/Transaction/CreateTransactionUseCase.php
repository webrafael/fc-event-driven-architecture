<?php namespace Wallet\Internal\UseCase\Transaction;

use DateTime;
use Ramsey\Uuid\Uuid;
use Wallet\Internal\Gateway\AccountGateway;
use Wallet\Integration\Events\Contracts\IEvent;
use Wallet\Internal\Gateway\TransactionGateway;
use Wallet\Integration\Events\Contracts\IEventDispatcher;
use Wallet\Internal\Entity\Transaction\TransactionEntity;
use Wallet\Internal\UseCase\Transaction\DTO\BalanceUpdatedOutputDto;
use Wallet\Internal\UseCase\Transaction\DTO\CreateTransactionInputDto;
use Wallet\Internal\UseCase\Transaction\DTO\CreateTransactionOutputDto;

class CreateTransactionUseCase
{
    public function __construct(
        protected AccountGateway $accountGateway,
        protected TransactionGateway $transactionGateway,
        protected IEventDispatcher $eventDispatcher,
        protected IEvent $transactionCreated,
        protected IEvent $balanceUpdated,
    ) { }

    public function execute(CreateTransactionInputDto $input): CreateTransactionOutputDto
    {
        $accountFrom = $this->accountGateway->findById($input->account_id_from);
        $accountTo = $this->accountGateway->findById($input->account_id_to);

        $transaction = new TransactionEntity(
            id: Uuid::uuid4(),
            accountFrom: $accountFrom,
            accountFromId: $accountFrom->id,
            accountTo: $accountTo,
            accountToId: $accountTo->id,
            amount: $input->amount,
            createdAt: new DateTime('now')
        );

        $output = new CreateTransactionOutputDto(
            id: $transaction->id,
            account_id_from: $transaction->accountFromId,
            account_id_to: $transaction->accountToId,
            amount: $transaction->amount
        );

        $balanceUpdatedOutput = new BalanceUpdatedOutputDto(
            id: Uuid::uuid4(),
            account_id_from: $input->account_id_from,
            account_id_to: $input->account_id_to,
            balance_account_id_from: $accountFrom->balance,
            balance_account_id_to: $accountTo->balance,
        );

        $this->accountGateway->updateBalance($accountFrom);

        $this->accountGateway->updateBalance($accountTo);

        $this->transactionGateway->create($transaction);

        $this->transactionCreated->setPayload($output);
        $this->eventDispatcher->dispatch($this->transactionCreated);

        $this->balanceUpdated->setPayload($balanceUpdatedOutput);
        $this->eventDispatcher->dispatch($this->balanceUpdated);

        return $output;
    }
}
