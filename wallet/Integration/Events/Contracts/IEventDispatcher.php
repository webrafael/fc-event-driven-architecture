<?php namespace Wallet\Integration\Events\Contracts;

interface IEventDispatcher
{
    public function register(string $eventName, IEventHandler $handler): void;
    public function dispatch(IEvent $event): void;
    public function remove(string $eventName, IEventHandler $handler): void;
    public function has(string $eventName, IEventHandler $handler): bool;
    public function clear(): void;
}
