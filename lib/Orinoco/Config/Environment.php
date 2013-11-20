<?php
/**
 * Orinoco Framework - A lightweight PHP framework.
 *  
 * Copyright (c) 2008-2013 Ryan Yonzon, http://www.ryanyonzon.com/
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 */

// root directory
define('ROOT_DIR', '../../');

// framework related stuff
define('FRAMEWORK_BASE_DIR', ROOT_DIR . 'lib/Orinoco/');
define('FRAMEWORK_LIB_DIR', FRAMEWORK_BASE_DIR . 'Framework/');
define('FRAMEWORK_CONFIG_DIR', FRAMEWORK_BASE_DIR . 'Config/');

// application related stuff
define('APPLICATION_BASE_DIR', ROOT_DIR . 'app/');
define('APPLICATION_CONFIG_DIR', APPLICATION_BASE_DIR . 'config/');
define('APPLICATION_CONTROLLER_DIR', APPLICATION_BASE_DIR . 'controller/');
define('APPLICATION_VENDOR_DIR', APPLICATION_BASE_DIR . 'vendor/');
define('APPLICATION_VIEW_DIR', APPLICATION_BASE_DIR . 'view/');
define('APPLICATION_LAYOUT_DIR', APPLICATION_VIEW_DIR . 'layout/');
define('APPLICATION_PAGE_DIR', APPLICATION_VIEW_DIR . 'page/');

// where to store opcode cache
define('APPLICATION_CACHE_DIR', APPLICATION_BASE_DIR . 'cache/');