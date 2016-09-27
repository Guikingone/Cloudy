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

/**
 * Class Listener
 * @package Cloudy\EventsManager\Model\Listener
 */
class Listener
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
     * @var string
     */
    protected $trigger;

    /**
     * @param \SplSubject $subject
     */
    public function update(\SplSubject $subject)
    {
        // TODO
    }
}