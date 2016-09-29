<?php

/*
 * This file is part of the Cloudy project.
 *
 * (c) Guillaume Loulier <guillaume.loulier@hotmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cloudy\EventsManager\Model\Listener;

use ArrayAccess;

/**
 * Interface ListenerInterface
 * @package Cloudy\EventsManager\Model\Listener
 */
interface ListenerInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @return string|object|null
     */
    public function getTrigger($name);

    /**
     * @return array
     */
    public function getTriggers();

    /**
     * @return boolean
     */
    public function isLazy();

    /**
     * @param $name
     */
    public function setName($name);

    /**
     * @param $status
     */
    public function setStatus($status);

    /**
     * @param string|ArrayAccess $name
     * @param string $value
     */
    public function setTrigger($name, $value);

    /**
     * @param $trigger
     */
    public function setTriggers($trigger);

    /**
     * @param $lazy
     */
    public function setLazy($lazy);
}