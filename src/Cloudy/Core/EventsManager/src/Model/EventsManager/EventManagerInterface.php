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

use Cloudy\EventsManager\Model\Events\EventsInterface;

/**
 * Interface EventManagerInterface
 * @package App\Core\EventsManager\Model\EventsManager
 */
interface EventManagerInterface
{
    /**
     * Use this method in order to initialize a new Event.
     *
     * This method allow to create a event and send him with all the listeners linked to this Event.
     *
     * Required :
     *
     * - The name of the Event.
     * - The target of the Event.
     * - The arguments asked by the Event (can be null).
     *
     * @param string $eventName
     * @param null|string|object $target
     * @param array|object $arguments
     * @return mixed
     */
    public function send($eventName, $target = null, array $arguments);

    /**
     * Use this method to initialize a new Event with 'n' callbacks.
     *
     * This method allow to create a event and send him with all the listeners linked to this event.
     *
     * Required :
     *
     * - The name of the Event.
     * - The target of the Event.
     * - The arguments asked by the Event (can be null).
     * - The callbacks who's gonna be notified about the Event.
     *
     * @param callable $callback
     * @param string $eventName
     * @param null|string|object $target
     * @param array|object $arguments
     *
     * @return mixed
     */
    public function sendUntil(callable $callback, $eventName, $target = null, array $arguments);

    /**
     * Send a Event using EventsInterface instance, in order to be effective, all the listeners linked to this Event
     * are send in the same time.
     *
     * Required :
     *
     * - The name of the Event.
     *
     * @param EventsInterface $events
     *
     * @return mixed
     */
    public function sendEvent(EventsInterface $events);

    /**
     * Send a Event using EventsInterface instance, each listeners are passed to the callback and stored as listeners,
     * if the name of the Event is missing, a Exception is throw.
     *
     * Required :
     *
     * - The name of the Event.
     * - The callbacks linked to this Event.
     *
     * @param callable $callback
     * @param EventsInterface $events
     * @return mixed
     */
    public function sendEventUntil(callable $callback, EventsInterface $events);

    /**
     * Attach a Listener to a Events, you can add a priority to this listener.
     *
     * The priority allow to make the Listener more important, in order to be effective and not explode the memory, the
     * priority is locked between 1 and 20, 1 can be considered as the most important Listener and 20, the less important.
     *
     * @param string $eventName
     * @param callable $listener
     * @param integer $priority
     *
     * @return callable
     */
    public function attach($eventName, callable $listener, $priority);

    /**
     * Detach a Listener from a Event or from all the Events launched.
     *
     * @param callable $listener
     * @param null|string $eventName
     *
     * @return void
     */
    public function detach(callable $listener, $eventName = null);

    /**
     * Clear all the Listeners linked to a Event.
     *
     * @param $eventName
     *
     * @return void
     */
    public function clearListeners($eventName);
}