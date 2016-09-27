<?php

/*
 * This file is part of the Cloudy project.
 *
 * (c) Guillaume Loulier <guillaume.loulier@hotmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Events;

use PHPUnit\Framework\TestCase;
use Cloudy\EventsManager\Model\Events\Events;

class EventsTest extends TestCase
{
    public function testEvents()
    {
        $events = new Events('Hello World', null, null);
        static::assertEquals('Hello World', $events);
    }
}