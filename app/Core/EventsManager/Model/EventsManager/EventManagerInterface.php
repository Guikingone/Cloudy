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

use app\Core\EventsManager\Model\Events\EventsInterface;

/**
 * Interface EventManagerInterface
 * @package App\Core\EventsManager\Model\EventsManager
 */
interface EventManagerInterface
{
    /**
     * Create and send a Event.
     *
     * @param string $eventName
     * @param null|string|object $target
     * @param array|object $arguments
     * @return mixed
     */
    public function send($eventName, $target = null, array $arguments);

    /**
     * Allow to send a Event until something happen.
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
     * Send a Event using EventsInterface instance.
     *
     * @param EventsInterface $events
     *
     * @return mixed
     */
    public function sendEvent(EventsInterface $events);

    /**
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