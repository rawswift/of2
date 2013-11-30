<?php
/**
 * Orinoco Framework - A lightweight PHP framework.
 *  
 * Copyright (c) 2008-2013 Ryan Yonzon, http://www.ryanyonzon.com/
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 */

namespace Orinoco\Framework;

/**
 * Set of methods that perform common, often re-used functions.
 * Utility classes define these common methods under static scope.
 */
class Util
{
    /**
     * var_dump wrapper
     *
     * @return void
     */
    public function dump($obj)
    {
        var_dump($obj);
    }
}
