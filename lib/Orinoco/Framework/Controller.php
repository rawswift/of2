<?php
/**
 * Orinoco Framework - A lightweight PHP framework.
 *  
 * Copyright (c) 2008-2013 Ryan Yonzon, http://www.ryanyonzon.com/
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 */

namespace Framework;

use Framework\View;

class Controller extends View
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // nothing to do here
    }

    /**
     * Return the controller name via framework's Route class
     *
     * @return string; controller name
     */
    public function getController()
    {
        return \Framework\Route::getController();
    }

    /**
     * Return the action name via framework's Route class
     *
     * @return string; action name
     */
    public function getAction()
    {
        return \Framework\Route::getAction();
    }

    /**
     * Return the ID (based on request URI and route)
     *
     * @return int|string|bool
     */
    public function getID()
    {
        return \Framework\Route::hasID() ? \Framework\Route::getID() : false;
    }    
}