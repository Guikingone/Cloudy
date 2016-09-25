<?php

/*
 * This file is part of the Cloudy project.
 *
 * (c) Guillaume Loulier <guillaume.loulier@hotmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Core\ApplicationManager;

use App\Core\EventsManager\Model\EventManager\EventManagerInterface;

/**
 * Interface ApplicationInterface
 * @package App\Core\ApplicationManager
 */
interface ApplicationInterface extends EventManagerInterface
{
    /**
     * Check the Environnement used.
     *
     * @return mixed
     */
    public function getEnvironnement();

    /**
     * Grab the Request object.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getRequest();

    /**
     * Grab the Response object.
     *
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getResponse();

    /**
     * Check if the application is running.
     *
     * @return mixed
     */
    public function isRunning();

    /**
     * Run the application
     *
     * @return self
     */
    public function init();
}