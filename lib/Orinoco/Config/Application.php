<?php
/**
 * Orinoco Framework - A lightweight PHP framework.
 *  
 * Copyright (c) 2008-2013 Ryan Yonzon, http://www.ryanyonzon.com/
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 */

// use trailing slash on URI
// this has no use as of this time
define('USE_TRAILING_SLASH', false);

// default PHP extension
define('PHP_FILE_EXTENSION', '.php');

// controllers and actions stuff
define('SELF_CONTROLLER', 'SELF');
define('SELF_ACTION', 'SELF');

// define default controller, if it's not yet defined
if (!defined('DEFAULT_CONTROLLER')) {
    define('DEFAULT_CONTROLLER', 'index');
}

// define default action/method, if it's not yet defined
if (!defined('DEFAULT_ACTION')) {
    define('DEFAULT_ACTION', 'index');
}

// define opcode cache enabler, if it's not yet defined
if (!defined('CACHE_ENABLE')) {
    define('CACHE_ENABLE', false);
}

// define opcode cache expiry time, if it's not yet defined
if (!defined('CACHE_EXPIRES')) {
    define('CACHE_EXPIRES', 900); // 15mins
}

// presentation layer stuff
define('DEFAULT_LAYOUT', 'default');
