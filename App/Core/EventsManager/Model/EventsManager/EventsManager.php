<?php

/*
 * This file is part of the Cloudy project.
 *
 * (c) Guillaume Loulier <guillaume.loulier@hotmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Core\EventsManager\Model\EventManager;

use app\Core\EventsManager\Exception\MissingEventNameException;
use app\Core\EventsManager\Exception\NotEventsException;
use app\Core\EventsManager\Model\Events\Events;
use app\Core\EventsManager\Model\Events\EventsInterface;

/**
 * Class EventsManager
 * @package App\Core\EventsManager
 */
class EventsManager implements EventManagerInterface
{
    /**
     * The array containing the Event and the Listener linked.
     *
     * @var array
     */
    protected $events = [];

    /**
     * @var EventsInterface
     */
    protected $eventInterface;

    /**
     * EventsManager constructor.
     */
    public function __construct()
    {
        $this->eventInterface = new Events();
    }

    /**
     * @inheritdoc
     */
    public function send($eventName, $target = null, array $arguments)
    {
        $event = clone $this->eventInterface;
        $event->setName($eventName);
        $event->setTrigger($target);
        $event->setArguments($arguments);

        return $this->sendListeners($event);
    }

    /**
     * @inheritdoc
     */
    public function sendUntil(callable $callback, $eventName, $target = null, array $arguments)
    {
        // TODO: Implement sendUntil() method.
    }

    public function sendEvent(EventsInterface $events)
    {
        // TODO: Implement sendEvent() method.
    }

    public function sendEventUntil(callable $callback, EventsInterface $events)
    {
        // TODO: Implement sendEventUntil() method.
    }

    public function sendListeners(EventsInterface $events, callable $callback = null)
    {
        $eventName = $events->getName();

        if (null === $eventName) {
            throw new MissingEventNameException('Event name missing, required !');
        }

        $events->stopPropagation(false);
    }

    /**
     * @inheritdoc
     */
    public function attach($eventName, callable $listener, $priority)
    {
        try {
            if (!is_string($eventName)) {
                throw new NotEventsException();
            }
            $this->events[$eventName][(int) $priority][] = $listener;

            return $listener;

        } catch (NotEventsException $eventsException) {
            $eventsException->getMessage();
        }
    }

    /**
     * @inheritdoc
     */
    public function detach(callable $listener, $eventName = null)
    {
        // TODO: Implement detach() method.
    }

    /**
     * @inheritdoc
     */
    public function clearListeners($event)
    {
        if (array_key_exists($this->events, $event)) {
            unset($this->events[$event]);
        }
    }
}