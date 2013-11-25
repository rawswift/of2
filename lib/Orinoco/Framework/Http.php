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
     * Set HTTP header (response)
     *
     * @return void
     */
    public static function setHeader($header)
    {
        // check if $header is an array
        if (is_array($header)) {
            foreach ($header as $k => $v) {
                header($k . ": " . $v);
            }
        // else, assume $header is a string
        } else {
            header($header);
        }
    }
}
