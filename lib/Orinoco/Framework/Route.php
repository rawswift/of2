<?php
/**
 * Orinoco Framework - A lightweight PHP framework.
 *  
 * Copyright (c) 2008-2013 Ryan Yonzon, http://www.ryanyonzon.com/
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 */

namespace Orinoco\Framework;

class Route
{
    // route table (map)
    static public $route_table;
    // contains the raw URI request e.g. /foo/bar?id=123
    static public $request_uri;
    // contains the parsed URL components
    static public $components;
    // contains the actual controller and action (array)
    static public $request_map;
    // controller name
    static public $controller;
    // action name
    static public $action;
    // controller class path
    static public $path;
    // URI segments storage (e.g. /foo/:name/:id)
    static public $segments = array();

    /**
     * Constructor, setup properties
     *
     * @param request URI $request_uri
     * @return void
     */
    public function __construct($request_uri)
    {
        self::$request_uri = $request_uri;
    }

    /**
     * Set/add properties to route table (map)
     *
     * @param string regular expression string $uri
     * @param array property $method_map
     * @return void
     */
    public function setRoute($uri, $method_map)
    {
        self::$route_table[trim($uri)] = $method_map;
    }

    /**
     * Return the route table (array)
     *
     * @return array route table
     */
    public function getRouteTable()
    {
        return self::$route_table;
    }

    /**
     * Parse request URI
     *
     * @return bool; whether or not we have a matching route
     */
    public function parseRequest()
    {
        self::$components = parse_url(self::$request_uri);
        self::$request_map = preg_split("/\//", self::$components['path'], 0, PREG_SPLIT_NO_EMPTY);
        if ($match = self::matchRouteRule(self::$components['path'])) {
            self::$controller = ($match["controller"] === SELF_CONTROLLER) ? self::$request_map[0] : $match["controller"];
            self::$action = ($match["action"] === SELF_ACTION) ? self::$request_map[1] : $match["action"];
            if (isset($match["path"])) {
                self::$path = $match["path"];
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Return the controller name
     *
     * @return bool|string
     */
    public function getController()
    {
        return isset(self::$controller) ? self::$controller : false;
    }

    /**
     * Return the action name
     *
     * @return bool|string
     */
    public function getAction()
    {
        return isset(self::$action) ? self::$action : false;
    }

    /**
     * Check if controller class path is defined
     *
     * @return bool|string
     */
    public function isPathDefined()
    {
        if (isset(self::$path)) {
            // make sure there's no slashes on front (left) 
            return ltrim(self::$path, "/");
        }
        return false;
    }

    /**
     * Match request
     *
     * @return bool|array
     */
    private function matchRouteRule($subject)
    {
        foreach(self::$route_table as $k => $v) {
            $pattern = "@^". $k . "*$@i";
            if (preg_match($pattern, $subject)) {
                return $v;
            }
        }
        return false;
    }
}
