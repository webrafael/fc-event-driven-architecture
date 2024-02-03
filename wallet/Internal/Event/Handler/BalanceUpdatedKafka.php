<?php namespace Wallet\Internal\Event\Handler;

use Ramsey\Uuid\Uuid;
use Wallet\Integration\Events\Contracts\IEvent;
use Wallet\Integration\Events\Contracts\IEventHandler;
use Wallet\Integration\Kafka\KafkaProducer;

class BalanceUpdatedKafka extends IEventHandler
{
    public function __construct(protected KafkaProducer $producer)
    {
        $this->hash = Uuid::uuid4();
    }

    public function handle(IEvent $event): void
    {
        $this->producer->produce('balances', $event->getPayload());
    }
}
