<?php

/*
 * This file is part of the Cloudy project.
 *
 * (c) Guillaume Loulier <guillaume.loulier@hotmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cloudy\EventsManager\Model\EventManager;

use Cloudy\Core\EventsManager\src\Exception\EmptyListenerException;
use Cloudy\Core\EventsManager\src\Exception\MissingEventsParametersException;
use Cloudy\Core\EventsManager\src\Exception\NotListenerException;
use Cloudy\EventsManager\Exception\MissingEventNameException;
use Cloudy\EventsManager\Exception\NotEventsException;
use Cloudy\EventsManager\Model\Events\Events;
use Cloudy\EventsManager\Model\Events\EventsInterface;
use Cloudy\EventsManager\Model\Listener\Listener;

/**
 * Class EventsManager
 * @package Cloudy\EventsManager
 */
class EventsManager implements EventManagerInterface
{
    /**
     * The array containing the Events.
     *
     * @var array
     */
    protected $events = [];

    /**
     * The array containing the Listeners.
     *
     * @var array
     */
    protected $listeners = [];

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
    public function sendUntil(Listener $listener, $eventName, $target = null, array $arguments)
    {
        $event = clone $this->eventInterface;
        $event->setName($eventName);
        $event->setTrigger($target);
        $event->setArguments($arguments);

        return $this->sendListeners($event, $listener);
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
    public function sendEventUntil(Listener $listener, EventsInterface $events)
    {
        return $this->sendListeners($events, $listener);
    }

    protected function sendListeners(EventsInterface $events, Listener $listener)
    {
        $eventName = $events->getName();

        if (null === $eventName) {
            throw new MissingEventNameException('Event name missing, required !');
        }

        $events->stopPropagation(false);
    }

    /**
     *  Allow to send all the Events and Listeners.
     */
    protected function sendAll()
    {
        try {
            foreach ($this->events as $event) {
                if (!$event->getname() || !$event->getTrigger() || $event->getArguments()) {
                    throw new MissingEventsParametersException();
                }
                $this->send($event->getName(), $event->getTrigger(), $event->getArguments());
            }
        } catch (MissingEventsParametersException $missingEventsParametersException) {
            $missingEventsParametersException->getMessage();
        }
    }

    /**
     * @inheritdoc
     */
    public function attach($eventName, Listener $listener, $priority)
    {
        try {
            if (!is_string($eventName)) {
                throw new NotEventsException();
            }

            if (!$listener instanceof Listener) {
                throw new NotListenerException();
            }

            $this->listeners[$eventName][(int) $priority][] = $listener;

            return $listener;

        } catch (NotEventsException $eventsException) {
            $eventsException->getMessage();
        } catch (NotListenerException $listenerException) {
            $listenerException->getMessage();
        }
    }

    /**
     * @inheritdoc
     */
    public function detach($eventName = null, Listener $listener)
    {
        try {
            if (null === $eventName || '*' === $eventName ) {
                throw new EmptyListenerException();
            }

            if (!is_string($eventName)) {
                throw new \InvalidArgumentException('Expected a string, given "%s"', gettype($eventName));
            }

            if (!array_key_exists($eventName, $this->events)) {
                return;
            }

            foreach ($this->events as $event => $listeners) {
                foreach ($listeners as $index => $linkedListener) {
                    if (null === $linkedListener) {
                        throw new EmptyListenerException();
                    }

                    unset($this->events[$index]);
                }

                if (empty($this->events[$eventName])) {
                    break;
                }

                unset($this->events[$event]);
            }
        } catch (\InvalidArgumentException $argumentException) {
            $argumentException->getMessage();
        } catch (EmptyListenerException $emptyListenerException) {
            $emptyListenerException->getMessage();
        }
    }

    /**
     * @inheritdoc
     */
    public function clearListeners($listener)
    {
        if (array_key_exists($this->listeners, $listener)) {
            unset($this->listeners[$listener]);
        }
    }

    /**
     * @inheritdoc
     */
    public function clearAllListeners()
    {
        $this->events = [];
    }

    /**
     * Get listeners for the currently send event.
     *
     * @param  string $eventName
     * @return callable[]
     */
    public function getListenersByEventName($eventName)
    {
        $listeners = array_merge_recursive(
            array_key_exists($this->events, $eventName) ? $this->events[$eventName] : [],
            array_key_exists($this->events, '*') ? $this->events['*'] : []
        );

        krsort($listeners, SORT_NUMERIC);

        $listenersForEvent = [];

        foreach ($listeners as $priority => $listenerEvents) {
            foreach ($listenerEvents as $listener) {
                $listenersForEvent[] = $listener;
            }
        }

        return $listenersForEvent;
    }

    /**
     * @param EventsInterface $eventInterface
     */
    public function setEventInterface($eventInterface)
    {
        $this->eventInterface = $eventInterface;
    }

    /**
     * @inheritdoc
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @inheritdoc
     */
    public function getListeners()
    {
        return $this->listeners;
    }
}