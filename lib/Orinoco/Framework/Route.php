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
    public static $route_table;
    // contains the raw URI request e.g. /foo/bar?id=123
    public static $request_uri;
    // contains the parsed URL components
    public static $components;
    // contains the actual controller and action (array)
    public static $request_map;
    // controller name
    public static $controller;
    // action name
    public static $action;
    // controller class path
    public static $path;
    // URI segments storage (e.g. /foo/:name/:id)
    public static $segments = array();

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
            $filters = array();
            if (isset($v['filters'])) {
                $filters = $v['filters'];
            }
            $callback = function($matches) use ($filters) {
                if (isset($matches[1]) && isset($filters[$matches[1]])) {
                    return $filters[$matches[1]];
                }
                return '(\w+)';
            };
            $pattern = "@^" . preg_replace_callback("/:(\w+)/", $callback, $k) . "$@i";
            $matches = array();
            if (preg_match($pattern, $subject, $matches)) {
                if(strpos($k, ':') !== false) {
                    if (preg_match_all("/:(\w+)/", $k, $segment_keys)) {
                        array_shift($matches);
                        array_shift($segment_keys);
                        foreach ($segment_keys[0] as $key => $name) {
                            self::$segments[$name] = $matches[$key];
                        }
                    }
                }
                return $v;
            }
        }
        return false;
    }

    /**
     * Get segment value
     *
     * @param string $name
     * @return int|string|bool
     */
    public function getSegment($name)
    {
        if (isset(self::$segments[$name])) {
            return self::$segments[$name];
        }
        return false;
    }    
}
