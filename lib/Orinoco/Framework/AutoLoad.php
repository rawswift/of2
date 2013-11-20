<?php
/**
 * Orinoco Framework - A lightweight PHP framework.
 *  
 * Copyright (c) 2008-2013 Ryan Yonzon, http://www.ryanyonzon.com/
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 */

namespace Framework;

class AutoLoad
{
    /**
     * Try to autoload framework related class
     *
     * @param Class name $class_name
     * @return void
     */
    public static function autoLoadFramework($class_name)
    {
        $class_name = ltrim($class_name, '\\');
        $file_name  = '';
        $namespace = '';
        if ($last_ns_pos = strrpos($class_name, '\\')) {
            $namespace = substr($class_name, 0, $last_ns_pos);
            $class_name = substr($class_name, $last_ns_pos + 1);
            $file_name  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $file_name .= str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.php';
        if (file_exists(FRAMEWORK_BASE_DIR . $file_name)) {
            require FRAMEWORK_BASE_DIR . $file_name;
        }
    }

    /**
     * Try to autoload application's controller class
     *
     * @param Class name $class_name
     * @return void
     */
    public static function autoLoadController($class_name)
    {
        $class_name = ltrim($class_name, '\\');
        $file_name  = '';
        $namespace = '';
        if ($last_ns_pos = strrpos($class_name, '\\')) {
            $namespace = substr($class_name, 0, $last_ns_pos);
            $class_name = substr($class_name, $last_ns_pos + 1);
            $file_name  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $file_name .= str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.php';
        if (file_exists(APPLICATION_CONTROLLER_DIR . $file_name)) {
            require APPLICATION_CONTROLLER_DIR . $file_name;
        }
    }

    /**
     * Register framework's autoload methods
     *
     * @return void
     */
    public static function register()
    {
        spl_autoload_register(array('Framework\AutoLoad', 'autoLoadFramework')); // register class Framework\AutoLoad::autoLoadFramework
        spl_autoload_register(array('Framework\AutoLoad', 'autoLoadController')); // register class Framework\AutoLoad::autoLoadController
    }
}