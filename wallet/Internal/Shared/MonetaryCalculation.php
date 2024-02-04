<?php namespace Wallet\Internal\Shared;

class MonetaryCalculation
{
    public function __construct(protected float|int $balance)
    { }

    private function setBalance(string $balance)
    {
        $this->balance = floatval($balance);
    }

    public function getBalance(): float|int
    {
        return $this->balance;
    }

    public function credit(float|int $value): MonetaryCalculation
    {
        if (bccomp(strval($value), '0') <= 0) {
            throw new \InvalidArgumentException("O valor a ser creditado deve ser maior que zero.");
        }

        $this->setBalance(
            bcadd(strval($this->balance), strval($value), 2)
        );

        return $this;
    }

    public function debit(float|int $value): MonetaryCalculation
    {
        if (bccomp(strval($value), '0') <= 0) {
            throw new \InvalidArgumentException("O valor a ser debitado deve ser maior que zero.");
        }

        if (bccomp(strval($value), strval($this->balance)) > 0) {
            throw new \RuntimeException("Saldo insuficiente para debitar o valor especificado.");
        }

        $this->setBalance(
            bcsub(strval($this->balance), strval($value), 2)
        );

        return $this;
    }
}
