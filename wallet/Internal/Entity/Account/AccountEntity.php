<?php namespace Wallet\Internal\Entity\Account;

use DateTime;
use Wallet\Internal\Entity\Client\ClientEntity;
use Wallet\Internal\Shared\MonetaryCalculation;
use Wallet\Internal\Entity\Exception\InvalidEntityException;

class AccountEntity
{
    private MonetaryCalculation $calculator;

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
        public float|int $balance = 0.0,
        public ?DateTime $createdAt = null,
        public ?DateTime $updatedAt = null
    ) {
        $this->calculator = new MonetaryCalculation($this->balance);
    }

    public function credit(float|int $amount)
    {
        $this->balance   = $this->calculator->credit($amount)->getBalance();
        $this->updatedAt = new DateTime('now');
    }

    public function debit(float|int $value)
    {
        $this->balance   = $this->calculator->debit($value)->getBalance();
        $this->updatedAt = new DateTime('now');
    }
}
