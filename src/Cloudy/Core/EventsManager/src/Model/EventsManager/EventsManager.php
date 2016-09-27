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

use Cloudy\EventsManager\Exception\MissingEventNameException;
use Cloudy\EventsManager\Exception\NotEventsException;
use Cloudy\EventsManager\Model\Events\Events;
use Cloudy\EventsManager\Model\Events\EventsInterface;

/**
 * Class EventsManager
 * @package Cloudy\EventsManager
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
        $event = clone $this->eventInterface;
        $event->setName($eventName);
        $event->setTrigger($target);
        $event->setArguments($arguments);

        return $this->sendListeners($event, $callback);
    }

    /**
     * @inheritdoc
     */
    public function sendEvent(EventsInterface $events)
    {
        return $this->sendListeners($events);
    }

    /**
     * @inheritdoc
     */
    public function sendEventUntil(callable $callback, EventsInterface $events)
    {
        return $this->sendListeners($events, $callback);
    }

    protected function sendListeners(EventsInterface $events, callable $callback = null)
    {
        $eventName = $events->getName();

        if (null === $eventName) {
            throw new MissingEventNameException('Event name missing, required !');
        }

        $events->stopPropagation(false);

        $responses = [];

        foreach ($this->getListenersByEventName($eventName) as $listener) {
            $response = $listener($events);
            $responses[$response];

            // If the event was asked to stop propagating, do so
            if ($events->isStopPropagation()) {
                $responses->setStopped(true);
                break;
            }

            if ($callback && $callback($response)) {
                $responses->setStopped(true);
                break;
            }
        }

        return $responses;
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
        try {
            if (null === $eventName || '*' === $eventName ) {
                foreach ($this->events as $event) {
                    $this->detach($listener, $event);
                }
                return;
            }

            if (!is_string($eventName)) {
                throw new \InvalidArgumentException('Expected a string, given "%s"', gettype($eventName));
            }

            if (!array_key_exists($this->events, $eventName)) {
                return;
            }

            foreach ($this->events[$eventName] as $priority => $listeners) {
                foreach ($listeners as $index => $evaluatedListener) {
                    if ($evaluatedListener !== $listener) {
                        continue;
                    }

                    unset($this->events[$eventName][$priority][$index]);

                    if (empty($this->events[$eventName][$priority])) {
                        unset($this->events[$eventName][$priority]);
                        break;
                    }
                }

                if (empty($this->events[$eventName])) {
                    unset($this->events[$eventName]);
                    break;
                }
            }
        } catch (\InvalidArgumentException $argumentException) {
            $argumentException->getMessage();
        }
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

    /**
     * Get listeners for the currently send event.
     *
     * @param  string $eventName
     * @return callable[]
     */
    protected function getListenersByEventName($eventName)
    {
        $listeners = array_merge_recursive(
            array_key_exists($this->events, $eventName) ? $this->events[$eventName] : [],
            array_key_exists($this->events, '*') ? $this->events['*'] : []
        );

        krsort($listeners, SORT_NUMERIC);

        $listenersForEvent = [];

        foreach ($listeners as $priority => $listenersByPriority) {
            foreach ($listenersByPriority as $listener) {
                $listenersForEvent[] = $listener;
            }
        }

        return $listenersForEvent;
    }
}