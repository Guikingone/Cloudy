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

use Cloudy\EventsManager\Model\Events\EventsInterface;
use Cloudy\EventsManager\Model\Listener\Listener;

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
     * @param Listener $listener
     * @param string $eventName
     * @param null|string|object $target
     * @param array|object $arguments
     *
     * @return mixed
     */
    public function sendUntil(Listener $listener, $eventName, $target = null, array $arguments);

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
     * @param Listener $listener
     * @param EventsInterface $events
     * @return mixed
     */
    public function sendEventUntil(Listener $listener, EventsInterface $events);

    /**
     * Attach a Listener to a Events, you can add a priority to this listener.
     *
     * The priority allow to make the Listener more important, in order to be effective and not explode the memory, the
     * priority is locked between 1 and 20, 1 can be considered as the most important Listener and 20, the less important.
     *
     * @param string $eventName
     * @param Listener $listener
     * @param integer $priority
     *
     * @return callable
     */
    public function attach($eventName, Listener $listener, $priority);

    /**
     * Detach a Listener from a Event or from all the Events launched.
     *
     * @param null|string $eventName
     * @param Listener $listener
     *
     * @return void
     */
    public function detach($eventName = null, Listener $listener);

    /**
     * Clear all the Listeners linked to a Event.
     *
     * @param string $listener
     *
     * @return void
     */
    public function clearListeners($listener);

    /**
     *  Allow to clear all the listeners.
     */
    public function clearAllListeners();

    /**
     * Allow to get all the Events stocked in the EventsManager.
     *
     * @return array
     */
    public function getEvents();

    /**
     * Allow to get all the listeners stocked into the EventsManager.
     *
     * @return array
     */
    public function getListeners();
}