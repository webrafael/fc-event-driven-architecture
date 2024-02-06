<?php namespace Wallet\Internal\Entity\Transaction;

use DateTime;
use Wallet\Internal\Entity\Account\AccountEntity;
use Wallet\Internal\Entity\Exception\InvalidEntityException;

class TransactionEntity
{
    public function __construct(
        public ?string $id = null,
        public ?AccountEntity $accountFrom = null,
        public ?string $accountFromId = null,
        public ?AccountEntity $accountTo = null,
        public ?string $accountToId = null,
        public float|int $amount = 0.0,
        public ?DateTime $createdAt = null,
    ) {
        $this->debitFromAccount();
        $this->creditToAccount();
    }

    public function debitFromAccount(): void
    {
        if (is_null($this->accountFrom)) {
            throw new InvalidEntityException("É necessário uma conta de origem para efetuar uma transação.");
        }

        $this->accountFrom->debit($this->amount);
    }

    public function creditToAccount(): void
    {
        if (is_null($this->accountTo)) {
            throw new InvalidEntityException("É necessário uma conta de destino para efetuar uma transação.");
        }

        $this->accountTo->credit($this->amount);
    }
}
