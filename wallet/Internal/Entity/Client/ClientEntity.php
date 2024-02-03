<?php namespace Wallet\Internal\Entity\Client;

use DateTime;
use Wallet\Internal\Entity\Account\AccountEntity;
use Wallet\Internal\Entity\Exception\InvalidEntityException;

class ClientEntity
{
    /**
     * @param string|null $id
     * @param string|null $name
     * @param string|null $email
     * @param DateTime|null $createdAt
     * @param DateTime|null $updatedAt
     */
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?string $email = null,
        public ?DateTime $createdAt = null,
        public ?DateTime $updatedAt = null
    ) {
        $this->validation();
    }

    public function validation()
    {
        if (is_null($this->name) || empty($this->name)) {
            throw new InvalidEntityException("O nome é obrigatório");
        }

        if (is_null($this->email) || empty($this->email)) {
            throw new InvalidEntityException("O email é obrigatório");
        }
    }
}
