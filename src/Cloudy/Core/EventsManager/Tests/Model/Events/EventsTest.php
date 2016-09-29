<?php

/*
 * This file is part of the Cloudy project.
 *
 * (c) Guillaume Loulier <guillaume.loulier@hotmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cloudy\EventsManager\Tests\Model\Events;

use PHPUnit\Framework\TestCase;
use Cloudy\EventsManager\Model\Events\Events;

/**
 * Class EventsTest
 * @package Tests\Events
 */
class EventsTest extends TestCase
{
    /**
     *  Test if the Events accept the arguments needed and contains this values.
     */
    public function testBootEvents()
    {
        $events = new Events('Hello World', ['onInit', 'onBoot'], 'onBoot');
        static::assertContains('Hello World', $events->getName());
        static::assertContains('onInit', $events->getArguments());
        static::assertContains('onBoot', $events->getTrigger());
    }

    /**
     * Test if the Events accept a new name and if it contains this value.
     */
    public function testEventsName()
    {
        $events = new Events('onBoot', ['onBoot', 'onInit'], 'onBoot');
        $events->setName('onRouterInit');
        static::assertContains('onRouterInit', $events->getName());
    }

    /**
     * Test if the Events accept a array of arguments and if it contains this values inside the array.
     */
    public function testEventsArguments()
    {
        $events = new Events('onInit', ['onBoot', 'onInit', 'onEventsManagerRun'], 'onInit');
        $events->setArguments(['onRouterInit', 'onResponseSend']);
        static::assertEquals(['onRouterInit', 'onResponseSend'], $events->getArguments());
    }

    /**
     * Test if the Events accept an array of arguments and if it can find one of the arguments.
     */
    public function testEventsArgument()
    {
        $events = new Events('onInit', ['onInit', 'onBoot'], 'onInit');
        static::assertEquals(['onInit', 'onBoot'], $events->getArgument('onBoot', $events->getArguments()));
    }

    /**
     * Test if the Events accept a new Trigger and if it contains the value.
     */
    public function testEventsTrigger()
    {
        $events = new Events('onInit', ['onBoot', 'onInit', 'onEventsManagerRun'], 'onInit');
        $events->setTrigger('onRouterInit');
        static::assertContains('onRouterInit', $events->getTrigger());
    }

    /**
     * Test if the Events can stop the propagation and if the return's correct.
     */
    public function testEventsStopPropagation()
    {
        $events = new Events('onInit', ['onInit', 'onBoot'], 'onInit');
        $events->stopPropagation(true);
        static::assertEquals(true, $events->isStopPropagation());
    }
}