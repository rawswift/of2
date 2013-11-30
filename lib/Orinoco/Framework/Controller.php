<?php
/**
 * Orinoco Framework - A lightweight PHP framework.
 *  
 * Copyright (c) 2008-2013 Ryan Yonzon, http://www.ryanyonzon.com/
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 */

namespace Orinoco\Framework;

use Orinoco\Framework\Http;
use Orinoco\Framework\Route;
use Orinoco\Framework\View;

class Controller extends View
{
    /**
     * Return the controller name via framework's Route class
     *
     * @return string; controller name
     */
    public function getController()
    {
        return Route::getController();
    }

    /**
     * Return the action name via framework's Route class
     *
     * @return string; action name
     */
    public function getAction()
    {
        return Route::getAction();
    }

    /**
     * Redirect using header
     *
     * @param string|array $mixed
     * @param Use 'refresh' instead of 'location' $use_refresh
     * @param Time to refresh $refresh_time
     * @return void
     */
    public function redirect($mixed, $use_refresh = false, $refresh_time = 3)
    {
        $url = null;
        if (is_string($mixed)) {
            $url = trim($mixed);
        } else if (is_array($mixed)) {
            $controller = $this->getController();
            $action = null;
            if (isset($mixed['controller'])) {
                $controller = trim($mixed['controller']);
            }
            $url = '/' . $controller;
            if (isset($mixed['action'])) {
                $action = trim($mixed['action']);
            }
            if (isset($action)) {
                $url .= '/' . $action;
            }
            if (isset($mixed['query'])) {
                $query = '?';
                foreach ($mixed['query'] as $k => $v) {
                    $query .= $k . '=' . urlencode($v) . '&';
                }
                $query[strlen($query) - 1] = '';
                $query = trim($query);
                $url .= $query;
            }
        }
        if (!$use_refresh) {
            Http::setHeader('Location: ' . $url);
        } else {
            Http::setHeader('refresh:' . $refresh_time . ';url=' . $url);
        }
    }
}
