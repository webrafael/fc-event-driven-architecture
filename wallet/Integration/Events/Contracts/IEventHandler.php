<?php namespace Wallet\Integration\Events\Contracts;

abstract class IEventHandler
{
    public string $hash;
    abstract function handle(IEvent $event): void;
}
