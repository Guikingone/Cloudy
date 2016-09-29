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
}