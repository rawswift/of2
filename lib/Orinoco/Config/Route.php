<?php
/**
 * Orinoco Framework - A lightweight PHP framework.
 *  
 * Copyright (c) 2008-2013 Ryan Yonzon, http://www.ryanyonzon.com/
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 */

// see also: /lib/Orinoco/Config/Application.php, for default controller and action/method name

// [/controller/action/id/] or [/controller/action/id] e.g. /foo/bar/123456789
// NOTE: 'id' is the index location of the ID (numeric)
Framework\Route::add('(^\/+[a-zA-Z-\-]+\/+[a-zA-Z-\-]+\/+[0-9]+\/|\/+[a-zA-Z-\-]+\/+[a-zA-Z-\-]+\/+[0-9]+$)', array('controller' => SELF_CONTROLLER, 'action' => SELF_ACTION, 'id' => 2));

// [/controller/action/] or [/controller/action] e.g. /foo/bar
Framework\Route::add('(^\/+[a-zA-Z-\-]+\/+[a-zA-Z-\-]+\/|\/+[a-zA-Z-\-]+\/+[a-zA-Z-\-]+$)', array('controller' => SELF_CONTROLLER, 'action' => SELF_ACTION));

// [/controller/id/] or [/controller/id] e.g. /foo/123456789
// NOTE: 'id' is the index location of the ID
Framework\Route::add('(^\/+[a-zA-Z-\-]+\/+[0-9]+\/|\/+[a-zA-Z-\-]+\/+[0-9]+$)', array('controller' => SELF_CONTROLLER, 'action' => DEFAULT_ACTION, 'id' => 1));

// [/controller/] or [/controller] e.g. /foo
Framework\Route::add('(^\/+[a-zA-Z-\-]+\/|\/+[a-zA-Z-\-]+$)', array('controller' => SELF_CONTROLLER, 'action' => DEFAULT_ACTION));

// index/root (e.g. http://www.domain.tld/)
Framework\Route::add('(^\/$)', array('controller' => DEFAULT_CONTROLLER, 'action' => DEFAULT_ACTION));
