<?php

/*
 * This file is part of the Cloudy project.
 *
 * (c) Guillaume Loulier <guillaume.loulier@hotmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cloudy\Core\EventsManager\Tests\Model\EventsManager;

use PHPUnit\Framework\TestCase;
use Cloudy\EventsManager\Model\EventManager\EventsManager;
use Cloudy\EventsManager\Model\Listener\Listener;

/**
 * Class EventsManagerTest
 * @package Cloudy\Core\EventsManager\Tests\Model\EventsManager
 */
class EventsManagerTest extends TestCase
{
    /**
     *  Test if the EventsManager is created and if it's empty.
     */
    public function testEventsManagerBoot()
    {
        $eventsManager = new EventsManager();
        static::assertArrayNotHasKey('onRouterEvent', $eventsManager->getEvents());
    }

    /**
     * Test if the EventsManager is created and contains the Listener passed with the Events.
     */
    public function testEventsManagerAddListeners()
    {
        $eventsManager = new EventsManager();
        $listener = new Listener('onRouterListener', 'ON', ['onRouterInit'], true);
        $eventsManager->attach('onRouter', $listener, 20);
        static::assertArrayHasKey('onRouter', $eventsManager->getListeners());
        static::assertContains('onRouterListener', $listener->getName());
        static::assertContains('ON', $listener->getStatus());
        static::assertContains('onRouterInit', $listener->getTriggers());
    }

    public function testEventsManagerDetachListeners()
    {
        $eventsManager = new EventsManager();
        $listener = new Listener('onFormListener', 'ON', ['onFormInit', 'onFormSubmit'], true);
        $eventsManager->attach('onForm', $listener, 6);
        static::assertArrayNotHasKey('ON', $eventsManager->getEvents());
    }

    /**
     * Test if the EventsManager is created and if the Listeners linked can be detached.
     */
    public function testEventsManagerClearListeners()
    {
        $eventsManager = new EventsManager();
        $listener = new Listener('onRouterListener', 'ON', ['onRouterBoot', 'onRouterInit'], false);
        $eventsManager->attach('onRouter', $listener, 10);
        $eventsManager->clearListeners('onRouter');
        static::assertArrayNotHasKey(['onRouter'], $eventsManager->getListeners());
    }

    /**
     * Test if the EventsManager accept a new Listener and if he can be cleared with clearAllListeners.
     */
    public function testEventsManagerClearAllListeners()
    {
        $eventsManager = new EventsManager();
        $listener = new Listener('onRouterListener', 'OFF', ['onRouterBoot'], false);
        $eventsManager->attach('onRouter', $listener, 2);
        $eventsManager->clearAllListeners();
        static::assertArrayNotHasKey('onRouter', $eventsManager->getEvents());
    }
}