<?php

namespace Tests\Unit;

use DateTime;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Wallet\Integration\Events\Contracts\IEvent;
use Wallet\Integration\Events\Contracts\IEventHandler;
use Wallet\Integration\Events\EventDispatcher;


class EventDispatcherTest extends TestCase
{
    public function test_create_new_event()
    {
        $event = new Event(
            name: 'event-1',
            payload: '{}'
        );

        $handler = new Handler();
        $handler->handle($event);

        $dispatcher = new EventDispatcher;
        $dispatcher->register($event->getName(), $handler);

        $this->assertInstanceOf(EventDispatcher::class, $dispatcher);
    }

    public function test_clear_event()
    {
        $event = new Event( name: 'event-1', payload: '{}' );

        $event2 = new Event( name: 'event-2', payload: '{}' );

        $handler = new Handler();
        $handler->handle($event);

        $handler2 = new Handler();
        $handler2->handle($event2);

        $dispatcher = new EventDispatcher;
        $dispatcher->register($event->getName(), $handler);
        $dispatcher->register($event2->getName(), $handler2);

        $dispatcher->clear();

        $this->assertInstanceOf(EventDispatcher::class, $dispatcher);
        $this->assertCount(0, $dispatcher->handlers);
    }

    public function test_has_event()
    {
        $event = new Event( name: 'event-1', payload: '{}' );

        $event2 = new Event( name: 'event-2', payload: '{}' );

        $event3 = new Event( name: 'event-3', payload: '{}' );

        $handler = new Handler();
        $handler->handle($event);

        $handler2 = new Handler();
        $handler2->handle($event2);

        $handler3 = new Handler();
        $handler3->handle($event3);

        $dispatcher = new EventDispatcher;
        $dispatcher->register($event->getName(), $handler);
        $dispatcher->register($event2->getName(), $handler2);

        $hasHandler = $dispatcher->has($event->getName(), $handler);
        $hasHandlerFalse = $dispatcher->has($event3->getName(), $handler3);

        $this->assertTrue($hasHandler);
        $this->assertFalse($hasHandlerFalse);
    }

    public function test_dispatch_event()
    {
        $dispatcher = $this->getMockBuilder(EventDispatcher::class)->getMock();

        // checa se o dispatch foi invocado pelo menos 1 vez
        $dispatcher->expects($this->once())->method('dispatch');

        $event = new Event( name: 'event-1', payload: '{}' );

        $event2 = new Event( name: 'event-2', payload: '{}' );

        $event3 = new Event( name: 'event-3', payload: '{}' );

        $handler = new Handler();
        $handler->handle($event);

        $handler2 = new Handler();
        $handler2->handle($event2);

        $handler3 = new Handler();
        $handler3->handle($event3);

        $dispatcher->register($event->getName(), $handler);
        $dispatcher->register($event2->getName(), $handler2);

        $dispatcher->dispatch($event);
    }
}

class Event implements IEvent
{
    public function __construct(
        protected string $name,
        protected $payload,
    ) { }

    public function getName(): string
    {
        return $this->name;
    }

    public function setPayload($payload)
    {
        return $this->payload = $payload;
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function getDateTime(): DateTime
    {
        return new DateTime('now');
    }
}

class Handler extends IEventHandler
{
    public function __construct()
    {
        $this->hash = Uuid::uuid4();
    }

    public function handle(IEvent $event): void
    {
        $event->getPayload();
    }
}
