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

/**
 * Interface EventManagerInterface
 * @package App\Core\EventsManager
 */
interface EventManagerInterface
{
    /**
     * @return mixed
     */
    public function isStatus();

    /**
     * @param $status
     */
    public function setStatus($status);

    /**
     * @return array
     */
    public function getEvents();

    /**
     * @param $event | The Event who's gonna been add.
     *
     * @return mixed
     */
    public function addEvents($event);

    /**
     * @param $event | The event to delete.
     *
     * @return mixed
     */
    public function removeEvents($event);

    /**
     * @return mixed
     */
    public function purgeEvents();

    /**
     * @return self
     */
    public function run();

    /**
     * @return mixed
     */
    public function init();
}