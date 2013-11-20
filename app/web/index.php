<?php
/**
 * Orinoco Framework - A lightweight PHP framework.
 *  
 * Copyright (c) 2008-2013 Ryan Yonzon, http://www.ryanyonzon.com/
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 */

// Turn ON all error reporting
error_reporting(E_ALL);

// ...or turn it OFF
// error_reporting(0);

// start output buffering, let View class handle the flushing of contents
ob_start();

// load framework's environment config
require '../../lib/Orinoco/Config/Environment.php';
// load framework's autload class
require FRAMEWORK_LIB_DIR . 'AutoLoad.php';

// register framework's autoload methods
$autoload = new Framework\AutoLoad();
$autoload->register();

// load developer's config, if available
$app_config = APPLICATION_CONFIG_DIR . 'Application.php';
if (file_exists($app_config)) {
    require $app_config;
}

// load framework's config (default app config)
require FRAMEWORK_CONFIG_DIR . 'Application.php';

// instantiate required framework libs
$http = new Framework\Http($_SERVER);
$view = new Framework\View();
$cache = new Framework\Cache();

// used for checking opcode cache
$cache_file = md5($http::getRequestURI());

// use opcode cache (using APC), if it's available
if (CACHE_ENABLE && $cache->isCacheAvailable() && $cache->isCacheDirWritable() && $cache->isCached($cache_file)) {
    $view->setContent($cache->readCache($cache_file));
    $view->send();
} else {

    // load vendor (Composer) autoload, if it's available
    if (file_exists(APPLICATION_VENDOR_DIR . 'autoload.php')) {
        require APPLICATION_VENDOR_DIR . 'autoload.php';
    }

    // instantiate Route class, used for determining controller and action to be used
    $route = new Framework\Route($http::getRequestURI());

    // load developer's route config
    $custom_routes = APPLICATION_CONFIG_DIR . 'Route.php';
    if (file_exists($custom_routes)) {
        require $custom_routes;
    }

    // load common/default route rules
    $common_routes = FRAMEWORK_CONFIG_DIR . 'Route.php';
    if (file_exists($common_routes)) {
        require $common_routes;
    }

    // parse request, the actual URI parsing process. return's false if no route is found
    if ($route->parseRequest()) {
        // if all goes well, instantiate Constructor class
        $constructor = new \Framework\Constructor($route);
        // ...then dispatch the requested controller and action method
        $constructor->dispatch();
        // check if we need to cache (opcode)
        if (CACHE_ENABLE && $cache->isCacheAvailable() && $cache->isCacheDirWritable()) {
            $cache_contents = ob_get_contents();
            $cache->writeCache($cache_file, $cache_contents);
        }
        // finally, render the request's content
        $view->send();
    } else {
        $http->setHeader('HTTP/1.0 404 Not Found');
        $view->setContent('Route Not Found');
        $view->send();
    }

}

// cleanup output buffer
ob_end_clean();