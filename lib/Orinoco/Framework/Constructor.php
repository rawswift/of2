<?php
/**
 * Orinoco Framework - A lightweight PHP framework.
 *  
 * Copyright (c) 2008-2013 Ryan Yonzon, http://www.ryanyonzon.com/
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 */

namespace Orinoco\Framework;

use Orinoco\Framework\Http;
use Orinoco\Framework\View;
use Orinoco\Framework\Controller;

class Constructor extends Controller
{
    // controller name
    protected $controller;
    // action name
    protected $action;

    /**
     * Constructor, setup properties
     *
     * @param Route object $route
     * @return void
     */
    public function __construct($route)
    {
        $this->controller = $route->getController();
        $this->action = $route->getAction();
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
                // Inherit controller object's variables on-fly,
                // make them visible to the presentation layers
                foreach($$controller as $k => $v) {
                    $this->$k = $v;
                }
                if (View::viewEnabled()) {
                    View::renderLayout();
                }
            } else {
                Http::setHeader('HTTP/1.0 404 Not Found');
                View::setContent('Cannot find method "' . $action . '" on controller class "' . $controller . '"');
            }
        } else {
            Http::setHeader('HTTP/1.0 404 Not Found');
            View::setContent('Cannot find controller class "' . $controller . '"');
        }
        // check if we need to cache output/page and response header
        $cache_file = md5(Http::getRequestURI());
        if (View::cachePage() && View::isPageCacheDirWritable() && !View::isPageCached($cache_file)) {
            // serialize before storing
            $cache = array(
                    'header' => headers_list(),
                    'content' => ob_get_contents()
                );
            View::writePageCache($cache_file, serialize($cache));
        }
        View::send();
    }
}
