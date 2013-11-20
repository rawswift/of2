<?php
/**
 * Orinoco Framework - A lightweight PHP framework.
 *  
 * Copyright (c) 2008-2013 Ryan Yonzon, http://www.ryanyonzon.com/
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 */

// index/root domain route 
// Framework\Route::add("/", array("controller" => "index", "action" => "index"));

// controller and action/methods routes
// Framework\Route::add("/foo", array("controller" => "foo", "action" => "index"));
// Framework\Route::add("/foo/bar", array("controller" => "foo", "action" => "bar"));

// regular expression and controller path
// Framework\Route::add("(^\/+[a-zA-Z0-9-\-]+\/test+$)", array("controller" => "test", "action" => "index", "path" => "/path/to/test.php"));

// blog style
// [/year/month/day/blog-style-url/] or [/year/month/day/blog-style-url]
// NOTE: change the 'BLOG_CONTROLLER' to your actual controller that will handle this URI request
// Framework\Route::add('(^\/+[0-9]+\/+[0-9]+\/+[0-9]+\/+[a-zA-Z0-9-\--\;-\+]+\/|\/+[0-9]+\/+[0-9]+\/+[0-9]+\/+[a-zA-Z0-9-\--\;-\+]+$)' , array('controller' => 'blogController', 'action' => DEFAULT_ACTION));
