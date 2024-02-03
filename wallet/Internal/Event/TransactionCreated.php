<?php namespace Wallet\Internal\Event;

use DateTime;
use Wallet\Integration\Events\Contracts\IEvent;

class TransactionCreated implements IEvent
{
    public function __construct(
        protected ?string $name = null,
        protected $payload = null,
    ) { }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDateTime(): DateTime
    {
        return new DateTime('now');
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function setPayload($payload)
    {
        $this->payload = $payload;
    }
}
