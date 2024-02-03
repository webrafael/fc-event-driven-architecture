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
        public float $amount = 0.0,
        public ?DateTime $createdAt = null,
    ) {
        $this->validation();

        $this->debitFromAccount();
        $this->creditToAccount();
    }

    public function creditToAccount(): float
    {
        $this->accountTo->credit($this->amount);

        return $this->accountTo->balance;
    }

    public function debitFromAccount(): float
    {
        $this->accountFrom->debit($this->amount);

        return $this->accountFrom->balance;
    }

    public function validation()
    {
        if ($this->amount <= 0.0) {
            throw new InvalidEntityException("O valor deve ser maior que zero");
        }

        if ($this->accountFrom->balance < $this->amount) {
            throw new InvalidEntityException("Saldo insuficiente");
        }
    }
}
