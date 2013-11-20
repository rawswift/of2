<?php
/**
 * Orinoco Framework - A lightweight PHP framework.
 *  
 * Copyright (c) 2008-2013 Ryan Yonzon, http://www.ryanyonzon.com/
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 */

namespace Framework;

class Cache
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // nothing to do here
    }

    /**
     * Check if Opcode cache is available
     * 
     * @return bool; whether or not APC is available
     */
    public function isCacheAvailable()
    {
        if(extension_loaded('apc') && ini_get('apc.enabled')) {
            return true;
        }
        return false;
    }

    /**
     * Check if cache directory is writable
     * 
     * @return bool; whether or not cache directory is writable
     */
    public function isCacheDirWritable()
    {
        if (is_writable(APPLICATION_CACHE_DIR)) {
            return true;
        }
        return false;
    }

    /**
     * Check for cached file and when the content of file was changed
     * 
     * @param File name $file
     * @return bool; whether or not there's a cached file or the has it expired
     */
    public function isCached($file)
    {
        $cache_file = APPLICATION_CACHE_DIR . $file;
        $cachefile_created = (file_exists($cache_file)) ? @filemtime($cache_file) : 0;
        return ((time() - CACHE_EXPIRES) < $cachefile_created);
    }

    /**
     * Read cached file's content
     * 
     * @param File name $file
     * @return string; cache content
     */
    public function readCache($file)
    {
        $cache_file = APPLICATION_CACHE_DIR . $file;
        return file_get_contents($cache_file);
    }

    /**
     * Write to cached file
     * 
     * @param File name $file
     * @param Content $out
     * @return void
     */
    public function writeCache($file, $out)
    {
        $cache_file = APPLICATION_CACHE_DIR . $file;
        $fp = fopen($cache_file, 'w');
        fwrite($fp, $out);
        fclose($fp);
    }
}
