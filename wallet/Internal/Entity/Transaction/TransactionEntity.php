<?php namespace Wallet\Internal\Entity\Transaction;

use DateTime;
use Wallet\Internal\Entity\Account\AccountEntity;

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

    public function creditToAccount(): void
    {
        if (! is_null($this->accountTo)) {
            $this->accountTo->credit($this->amount);
        }
    }

    public function debitFromAccount(): void
    {
        if (! is_null($this->accountFrom)) {
            $this->accountFrom->debit($this->amount);
        }
    }
}
