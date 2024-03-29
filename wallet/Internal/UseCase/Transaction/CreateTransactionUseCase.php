<?php namespace Wallet\Internal\UseCase\Transaction;

use DateTime;
use Ramsey\Uuid\Uuid;
use Wallet\Internal\Gateway\AccountGateway;
use Wallet\Integration\Events\Contracts\IEvent;
use Wallet\Internal\Gateway\TransactionGateway;
use Wallet\Integration\Events\Contracts\IEventDispatcher;
use Wallet\Integration\Kafka\KafkaProducer;
use Wallet\Internal\Entity\Transaction\TransactionEntity;
use Wallet\Internal\Event\Handler\BalanceUpdatedKafka;
use Wallet\Internal\Event\Handler\TransactionCreatedKafka;
use Wallet\Internal\UseCase\Exception\InvalidUseCaseException;
use Wallet\Internal\Gateway\Transaction\DBTransactionInterface;
use Wallet\Internal\UseCase\Transaction\DTO\BalanceUpdatedOutputDto;
use Wallet\Internal\UseCase\Transaction\DTO\CreateTransactionInputDto;
use Wallet\Internal\UseCase\Transaction\DTO\CreateTransactionOutputDto;

class CreateTransactionUseCase
{
    protected IEvent $balanceUpdated;
    protected IEvent $transactionCreated;

    public function __construct(
        protected AccountGateway $accountGateway,
        protected TransactionGateway $transactionGateway,
        protected DBTransactionInterface $transaction,
        protected IEventDispatcher $eventDispatcher,
    ) { }

    public function withEvents(IEvent $balanceUpdated, IEvent $transactionCreated)
    {
        $this->balanceUpdated = $balanceUpdated;
        $this->transactionCreated = $transactionCreated;

        $this->eventDispatcher->register($this->balanceUpdated->getName(), new BalanceUpdatedKafka(new KafkaProducer));
        $this->eventDispatcher->register($this->transactionCreated->getName(), new TransactionCreatedKafka(new KafkaProducer));

        return $this;
    }

    public function execute(CreateTransactionInputDto $input): CreateTransactionOutputDto
    {
        try {
            $accountFrom = $this->accountGateway->findById($input->account_id_from);
            $accountTo = $this->accountGateway->findById($input->account_id_to);

            if (!$accountFrom) {
                throw new InvalidUseCaseException('Usuario de origem nao encontrado.');
            }

            if (!$accountTo) {
                throw new InvalidUseCaseException('Usuario de destino nao encontrado.');
            }

            $transaction = new TransactionEntity(
                id: Uuid::uuid4(),
                accountFrom: $accountFrom,
                accountFromId: $accountFrom->clientId,
                accountTo: $accountTo,
                accountToId: $accountTo->clientId,
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

            if (! is_null($this->transactionCreated) && !is_null($this->balanceUpdated)) {

                $this->transactionCreated->setPayload($output);
                $this->eventDispatcher->dispatch($this->transactionCreated);

                $this->balanceUpdated->setPayload($balanceUpdatedOutput);
                $this->eventDispatcher->dispatch($this->balanceUpdated);
            }

            $this->transaction->commit();

            return $output;

        } catch (\Throwable $thr) {
            $this->transaction->rollback();
            throw new InvalidUseCaseException($thr->getMessage(), 500);
        }
        catch (\Exception $exc) {
            $this->transaction->rollback();
            throw new InvalidUseCaseException($exc->getMessage(), 500);
        }
    }
}
