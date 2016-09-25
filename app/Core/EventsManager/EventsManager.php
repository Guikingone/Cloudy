<?php

/*
 * This file is part of the Cloudy project.
 *
 * (c) Guillaume Loulier <guillaume.loulier@hotmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Core\EventsManager;

use app\Core\EventsManager\Exception\NotEventManagerException;
use app\Core\EventsManager\Exception\NotEventsException;
use app\Core\EventsManager\Exception\NotRunEventsManagerException;
use app\Core\EventsManager\Exception\EmptyEventManager;
use App\Core\EventsManager\Model\Events;

/**
 * Class EventsManager
 * @package App\Core\EventsManager
 */
class EventsManager implements EventManagerInterface
{
    /**
     * The container of Events.
     *
     * @var array
     */
    protected $events = array();

    /**
     * Return the status of the EventsManager.
     *
     * @var boolean
     */
    protected $status;

    /**
     * EventsManager constructor.
     *
     * @param array $events
     * @param bool $status
     */
    public function __construct(array $events, $status)
    {
        $this->events = $events;
        $this->status = $status;
    }


    /**
     * @return boolean
     */
    public function isStatus()
    {
        return $this->status;
    }

    /**
     * @param boolean $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Return the array of Events.
     *
     * @return array
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Allow to add a new Event into the EventsManager.
     *
     * @param $event
     */
    public function addEvents($event)
    {
        try {
            if(null === $event) {
                throw new EmptyEventManager();
            }
            $this->events[$event->getName()];
        } catch (EmptyEventManager $e) {
            $e->getMessage();
        }
    }

    public function removeEvents($event)
    {
        try {
            unset($this->events[$event]);
        } catch (NotEventsException $eventsException) {
            $eventsException->getMessage();
        }
    }

    /**
     * Allow to purge all the Events stocked into the EventManager.
     */
    public function purgeEvents()
    {
        foreach ($this->getEvents() as $event) {
            unset($event);
        }
    }

    /**
     * Allow to initialize the EventsManager and check if the status is correct.
     *
     * @throws NotEventManagerException
     *
     * @return EventsManager
     */
    public function init()
    {
        if ($this->isStatus() !== true) {
            $this->setStatus(true);
        } else {
            throw new NotEventManagerException();
        }
        return $this;
    }

    /**
     * Allow to run the EventsManager only if the status is true.
     *
     * @throws NotRunEventsManagerException
     */
    public function run()
    {
        if ($this->isStatus() === true) {
            $this->events = [];
        } else {
            throw new NotRunEventsManagerException();
        }
    }
}