<?php

/*
 * This file is part of the $PROJECT project.
 *
 * (c) Guillaume Loulier <guillaume.loulier@hotmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\Core\Events;

use App\Core\EventsManager\Model\Events\Events;
use PHPUnit\Framework\TestCase;

class EventsTest extends TestCase
{
    public function testEvents()
    {
        $events = new Events('Hello World', null, null);
        static::assertEquals('Hello World', $events);
    }
}