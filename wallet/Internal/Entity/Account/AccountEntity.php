<?php namespace Wallet\Internal\Entity\Account;

use DateTime;
use Wallet\Internal\Entity\Client\ClientEntity;
use Wallet\Internal\Entity\Exception\InvalidEntityException;

class AccountEntity
{
    /**
     * @param string|null $id
     * @param ClientEntity|null $client
     * @param string|null $clientId
     * @param float $balance
     * @param DateTime|null $createdAt
     * @param DateTime|null $updatedAt
     */
    public function __construct(
        public ?string $id = null,
        public ?ClientEntity $client = null,
        public ?string $clientId = null,
        public float $balance = 0.0,
        public ?DateTime $createdAt = null,
        public ?DateTime $updatedAt = null
    ) { }

    public function credit(float $amount)
    {
        $this->balance += $amount;
        $this->updatedAt = new DateTime('now');
    }

    public function debit(float $value)
    {
        $this->canDebit($value);

        $value = strval($value);
        $current = strval($this->balance);
        $result = bcsub($current, $value, 2);

        $this->balance = floatval($result);

        $this->updatedAt = new DateTime('now');
    }

    private function canDebit(float $amount)
    {
        if ($this->balance < $amount) {
            throw new InvalidEntityException("Saldo insuficiente");
        }
    }
}
