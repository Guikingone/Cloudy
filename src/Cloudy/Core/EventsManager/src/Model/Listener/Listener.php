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
use Cloudy\EventsManager\Exception\InvalidListenerTriggerException;

/**
 * Class Listener
 * @package Cloudy\EventsManager\Model\Listener
 */
class Listener implements ListenerInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var boolean
     */
    protected $status;

    /**
     * @var array|ArrayAccess|object
     */
    protected $trigger;

    /**
     * @var boolean
     */
    protected $lazy;

    /**
     * Listener constructor.
     * @param string $name
     * @param string $status
     * @param array $trigger
     * @param bool $lazy
     */
    public function __construct($name, $status, array $trigger, $lazy = false)
    {
        if (null !== $name) {
            $this->setName($name);
        }

        if (null !== $status) {
            $this->setStatus($status);
        }

        if (null !== $trigger) {
            $this->setTriggers($trigger);
        }

        if (null !== $lazy) {
            $this->setLazy($lazy);
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param $name
     * @param null $default
     *
     * @return mixed|null
     */
    public function getTrigger($name, $default = null)
    {
        if (is_array($this->trigger) || $this->trigger instanceof ArrayAccess) {
            if (!array_key_exists($name, $this->trigger)) {
                return $default;
            }

            return $this->trigger[$name];
        }

        // Check if object
        if (!isset($this->trigger->{$name})) {
            return $default;
        }
        return $this->trigger->{$name};
    }

    /**
     * @return array|ArrayAccess|object
     */
    public function getTriggers()
    {
        return $this->trigger;
    }

    /**
     * @return bool
     */
    public function isLazy()
    {
        return $this->lazy;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param ArrayAccess|string $name
     * @param string $value
     */
    public function setTrigger($name, $value)
    {
        if (is_array($this->trigger) || $this->trigger instanceof ArrayAccess) {
            $this->trigger[$name] = $value;
            return;
        }

        $this->trigger->{$name} = $value;
    }

    /**
     * @param array|object|string $trigger
     */
    public function setTriggers($trigger)
    {
        try {
            if (!is_array($trigger) || !is_object($trigger)) {
                throw new InvalidListenerTriggerException(
                    sprintf('Incorrect Listener trigger, given "%s", expected string, array or object', gettype($trigger))
                );
            }
        } catch (InvalidListenerTriggerException $listenerArgumentException) {
            $listenerArgumentException->getMessage();
        }

        $this->trigger = $trigger;
    }

    /**
     * @param boolean $lazy
     */
    public function setLazy($lazy)
    {
        $this->lazy = $lazy;
    }
}