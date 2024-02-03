<?php namespace Wallet\Integration\Events;

use Wallet\Integration\Events\Contracts\IEvent;
use Wallet\Integration\Events\Contracts\IEventHandler;
use Wallet\Integration\Events\Contracts\IEventDispatcher;
use Wallet\Integration\Events\Exception\InvalidEventException;

class EventDispatcher implements IEventDispatcher
{
    /**
     * @var Array<string, IEventHandler>
     */
    public array $handlers = [];

    public function register(string $eventName, IEventHandler $handler): void
    {
        if (isset($this->handlers[$eventName])) {
            foreach($this->handlers[$eventName] as $thisHandler) {
                if ($thisHandler->hash == $handler->hash) {
                    throw new InvalidEventException("handler already registered");
                }
            }
        }

        $this->handlers[$eventName][] = $handler;
    }

    public function dispatch(IEvent $event): void
    {
        if (isset($this->handlers[$event->getName()])) {
            foreach($this->handlers[$event->getName()] ?? [] as $handler) {
                $handler->handle($event);
            }
        }
    }

    public function remove(string $eventName, IEventHandler $handler): void
    {
        if (isset($this->handlers[$eventName])) {
            foreach($this->handlers[$eventName] ?? [] as $index => $handle) {
                if ($handle->hash == $handler->hash) {
                    unset($this->handlers[$eventName][$index]);
                    return;
                }
            }
        }
    }

    public function has(string $eventName, IEventHandler $handler): bool
    {
        if (isset($this->handlers[$eventName])) {
            foreach($this->handlers[$eventName] ?? [] as $handle) {
                if ($handle->hash == $handler->hash) {
                    return true;
                }
            }
        }
        return false;
    }

    public function clear(): void
    {
        $this->handlers = [];
    }
}
