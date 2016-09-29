<?php

/*
 * This file is part of the Cloudy project.
 *
 * (c) Guillaume Loulier <guillaume.loulier@hotmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cloudy\Core\EventsManager\Tests\Model\Listener;

use Cloudy\EventsManager\Model\Listener\Listener;
use PHPUnit\Framework\TestCase;

/**
 * Class ListenerTest
 * @package Cloudy\Core\EventsManager\Tests\Model\Listener
 */
class ListenerTest extends TestCase
{
    /**
     *  Test if the Listener boot and if the data passed are alive.
     */
    public function testListenerBoot()
    {
        $listener = new Listener('onRouterEvent', 'ON', ['onRouterBoot', 'onRouterRequest'], true);
        static::assertContains('onRouterEvent', $listener->getName());
        static::assertContains('ON', $listener->getStatus());
        static::assertContains('onRouterBoot', $listener->getTriggers());
        static::assertTrue(true, $listener->isLazy());
    }

    /**
     *  Test if the Listener boot and if the name is set correctly.
     */
    public function testListenerName()
    {
        $listener = new Listener('onRouterEvent', 'OFF', [], false);
        $listener->setName('onFormSubmit');
        static::assertEquals('onFormSubmit', $listener->getName());
    }

    /**
     *  Test if the listener boot and if the status is set correctly.
     */
    public function testListenerStatus()
    {
        $listener = new Listener('onCoreInit', 'ON', ['onRouterBoot'], true);
        $listener->setStatus('OFF');
        static::assertEquals('OFF', $listener->getStatus());
    }

    /**
     *  Test of the Listener Boot and if the trigger is added.
     */
    public function testListenerTrigger()
    {
        $listener = new Listener('onRouterEvent', 'ON', ['onRouterBoot', 'onRouterInit', 'onRouterLaunch'], true);
        $listener->setTrigger('onRouterExec', ['onRouterInit', 'onRouterBoot']);
        static::assertContains('onRouterInit', $listener->getTrigger('onRouterExec'));
    }

    /**
     *  Test if the Listener boot and if the triggers are passed.
     */
    public function testListenerTriggers()
    {
        $listener = new Listener('onServiceBoot', 'ON', ['onCoreInit', 'onCoreBoot'], false);
        $listener->setTriggers(['onCoreInstance', 'onCoreAnalyse']);
        static::assertContains('onCoreAnalyse', $listener->getTriggers());
    }

    /**
     *  Test if the Listener boot and if it's lazy.
     */
    public function testListenerIsLazy()
    {
        $listener = new Listener('onFormInit', 'ON', [], false);
        $listener->setLazy(true);
        static::assertTrue(true, $listener->isLazy());
    }
}