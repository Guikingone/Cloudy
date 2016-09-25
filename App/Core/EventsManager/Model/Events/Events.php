<?php

/*
 * This file is part of the Cloudy project.
 *
 * (c) Guillaume Loulier <guillaume.loulier@hotmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Core\EventsManager\Model\Events;

use ArrayAccess;
use App\Core\EventsManager\Exception\InvalidEventArgumentException;

/**
 * Class Events
 *
 * Structure of a Event.
 *
 * @package App\Core\EventsManager\Model\Events
 */
class Events implements EventsInterface
{
    /**
     * The name of the event.
     *
     * @var string
     */
    protected $name;

    /**
     * The trigger who activate the event aka the event who's gonna be launched.
     *
     * @var string|object|null
     */
    protected $trigger;

    /**
     * The list of arguments used by the Event.
     *
     * @var array|ArrayAccess|object
     */
    protected $arguments = array();

    /**
     * Decide the status of the propagation inside the Event.
     *
     * @var bool
     */
    protected $stopPropagation = false;

    /**
     * Events constructor.
     *
     * Accept a name, list of arguments and a trigger.
     *
     * @param string $name
     * @param array|ArrayAccess $arguments
     * @param string|object $trigger
     */
    public function __construct($name = null, $arguments = null, $trigger = null)
    {
        if (null !== $name) {
            $this->setName($name);
        }

        if (null !== $arguments) {
            $this->setArguments($arguments);
        }

        if (null !== $trigger) {
            $this->setTrigger($trigger);
        }
    }

    /**
     * Return the event name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the event name.
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = (string) $name ;
    }

    /**
     * @return string
     */
    public function getTrigger()
    {
        return $this->trigger;
    }

    /**
     * @param string $trigger
     */
    public function setTrigger($trigger)
    {
        $this->trigger = $trigger;
    }

    /**
     * Return all the arguments.
     *
     * @return array|ArrayAccess|object $arguments
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Return a single arguments or an object, if null, $default value's returned.
     *
     * @param string|int $name
     * @param null $default
     *
     * @return mixed|null
     */
    public function getArgument($name, $default = null)
    {
        if (is_array($this->arguments) || $this->arguments instanceof ArrayAccess) {
            if (!array_key_exists($name, $this->arguments)) {
                return $default;
            }

            return $this->arguments[$name];
        }

        // Check if object
        if (!isset($this->arguments->{$name})) {
            return $default;
        }
        return $this->arguments->{$name};
    }

    /**
     * Set arguments.
     *
     * @param array|ArrayAccess|object $arguments
     */
    public function setArguments($arguments)
    {
        try {
            if (!is_array($arguments) && !is_object($arguments)) {
                throw new InvalidEventArgumentException(
                    sprintf('The parameters need to be an array or an object, receive "%s"', gettype($arguments)
                    ));
            }
        } catch (InvalidEventArgumentException $e) {
            $e->getMessage();
        }

        $this->arguments = $arguments;
    }

    /**
     * Set a single argument.
     *
     * @param string|int $name
     * @param mixed $value
     */
    public function setArgument($name, $value)
    {
        if (is_array($this->arguments) || $this->arguments instanceof ArrayAccess) {
            $this->arguments[$name] = $value;
            return;
        }

        $this->arguments->{$name} = $value;
    }

    /**
     * Return the state of the propagation.
     *
     * @return bool $stopPropagation
     */
    public function isStopPropagation()
    {
        return $this->stopPropagation;
    }

    /**
     * Allow to stop the propagation of the event.
     *
     * @param bool $default
     */
    public function stopPropagation($default = true)
    {
        $this->stopPropagation = (boolean) $default;
    }
}