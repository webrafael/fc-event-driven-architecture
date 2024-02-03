<?php namespace Wallet\Internal\UseCase\Balance;

use Wallet\Internal\Gateway\BalanceGateway;
use Wallet\Internal\UseCase\Exception\InvalidUseCaseException;
use Wallet\Internal\UseCase\Balance\DTO\GetBalanceByIdInputDto;
use Wallet\Internal\UseCase\Account\DTO\GetBalanceByIdOutputDto;

class GetBalanceByIdUseCase
{
    public function __construct(protected BalanceGateway $balanceGateway)
    { }

    public function execute(GetBalanceByIdInputDto $input): ?GetBalanceByIdOutputDto
    {
        try {
            $repository = $this->balanceGateway->getById($input->id);

            if (! $repository) {
                return null;
            }

            return new GetBalanceByIdOutputDto(
                id: $repository->id,
                client_id: $repository->clientId,
                balance: $repository->balance,
                created_at: $repository->createdAt,
                updated_at: $repository->updatedAt,
            );
        } catch(\Exception $exc) {
            throw new InvalidUseCaseException($exc->getMessage(), 500);
        }
    }
}
