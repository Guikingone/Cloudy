<?php

/*
 * This file is part of the Cloudy project.
 *
 * (c) Guillaume Loulier <guillaume.loulier@hotmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\Core\EventsManager\Model\Events;

use ArrayAccess;

/**
 * Interface EventsInterface
 * @package app\Core\EventsManager\Model\Events
 */
interface EventsInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string|object|null
     */
    public function getTrigger();

    /**
     * @return array|ArrayAccess|object
     */
    public function getArguments();

    /**
     * @param $name
     * @param null $default
     * @return mixed
     */
    public function getArgument($name, $default = null);

    /**
     * @return boolean
     */
    public function isStopPropagation();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @param string|object|null $trigger
     */
    public function setTrigger($trigger);

    /**
     * @param $arguments
     */
    public function setArguments($arguments);

    /**
     * @param string|int $name
     * @param $value
     */
    public function setArgument($name, $value);

    /**
     * @param bool $default
     */
    public function stopPropagation($default = true);
}