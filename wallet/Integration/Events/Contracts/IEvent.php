<?php namespace Wallet\Integration\Events\Contracts;

use DateTime;

interface IEvent
{
    public function getName(): string;
    public function getDateTime(): DateTime;
    public function getPayload();
    public function setPayload($payload);
}
