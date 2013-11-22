<?php
/**
 * Orinoco Framework - A lightweight PHP framework.
 *  
 * Copyright (c) 2008-2013 Ryan Yonzon, http://www.ryanyonzon.com/
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 */

namespace Orinoco\Framework;

use Orinoco\Framework\Http;
use Orinoco\Framework\Controller;

class Constructor extends Controller
{
    // controller name
    protected $controller;
    // action name
    protected $action;
    // ID storage
    protected $id = null;

    /**
     * Constructor, setup properties
     *
     * @param Route object $route
     * @return void
     */
    public function __construct($route)
    {
        $this->controller = $route::getController();
        $this->action = $route::getAction();
        if ($route->hasID()) {
            $this->id = $route->getID();
        }
    }

    /**
     * Dispatch, instantiate controller class, execute action method and then prepare/render view
     *
     * @return void
     */
    public function dispatch()
    {
        $controller = $this->controller;
        $action = $this->action;
        if (defined('APPLICATION_NAMESPACE')) {
            $controller = str_replace('\\', '', APPLICATION_NAMESPACE) . '\\' . $controller;
        }
        if (class_exists($controller)) {
            $$controller = new $controller();
            if (method_exists($$controller, $action)) {
                $$controller->$action();
                $this->inheritObjectVariables($$controller);
                $this->renderLayout();
            } else {
                Http::setHeader('HTTP/1.0 404 Not Found');
                $this->setContent('Cannot find method "' . $action . '" on controller class "' . $controller . '"');
                $this->send();
            }
        } else {
            Http::setHeader('HTTP/1.0 404 Not Found');
            $this->setContent('Cannot find controller class "' . $controller . '"');
            $this->send();
        }
    }
}
