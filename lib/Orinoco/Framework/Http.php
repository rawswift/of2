<?php
/**
 * Orinoco Framework - A lightweight PHP framework.
 *  
 * Copyright (c) 2008-2013 Ryan Yonzon, http://www.ryanyonzon.com/
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 */

namespace Orinoco\Framework;

class Http
{
    // $_SERVER storage
    private static $server;

    /**
     * Constructor, setup properties
     *
     * @param $_SERVER variable $server
     * @return void
     */
    public function __construct($server)
    {
        self::$server = $server;
    }

    /**
     * Return the $_SERVER['REQUEST_URI']
     *
     * @return string; request URI
     */
    public static function getRequestURI() {
        return self::$server['REQUEST_URI'];
    }

    /**
     * Return $server ($_SERVER) variable
     *
     * @return array $server ($_SERVER)
     */
    public static function getServerInfo() {
        return self::$server;
    }

    /**
     * Get value from $_SERVER array
     *
     * @param key name $name
     * @return string (value);
     */
    public static function getValue($name) {
        $name = strtoupper($name);
        if (isset(self::$server[$name])) {
            return self::$server[$name];
        }
        return false;
    }

    /**
     * Set HTTP header (response)
     *
     * @return void
     */
    public static function setHeader($header, $replace = true, $http_response_code = null)
    {
        // check if $header is an array
        if (is_array($header)) {
            foreach ($header as $k => $v) {
                header($k . ": " . $v, $replace, $http_response_code);
            }
        // else, assume $header is a string
        } else {
            header($header, $replace, $http_response_code);
        }
    }
}
