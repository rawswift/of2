<?php
/**
 * Orinoco Framework - A lightweight PHP framework.
 *  
 * Copyright (c) 2008-2013 Ryan Yonzon, http://www.ryanyonzon.com/
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 */

namespace Orinoco\Framework;

use Orinoco\Framework\Http;
use Orinoco\Framework\Route;

class View
{
    // layout name
    public static $layout;
    // whether or not to render view/template (HTML layout and HTML contents)
    // default is true (render view/template)
    public static $view_enabled = true;
    // whether or not to cache output/page and response header
    // default is false (do not cache)
    public static $cache_page = false;

    /**
     * Disable view/template rendering
     *
     * @return void
     */
    public static function disable()
    {
        self::$view_enabled = false;
    }

    /**
     * Get view flag
     *
     * @return bool; whether or not view is enabled
     */
    public function viewEnabled()
    {
        return self::$view_enabled;
    }

    /**
     * Set HTML layout
     *
     * @return void
     */
    public static function setLayout($layout_name)
    {
        self::$layout = $layout_name;
    }

    /**
     * Render presentation layout
     *
     * @return void
     */
    public function renderLayout()
    {
        // check if $layout is defined
        $layout = isset($this->layout) ? $this->layout : self::$layout;
        // check layout file
        if(isset($layout)) {
            $layout_file = APPLICATION_LAYOUT_DIR . str_replace(PHP_FILE_EXTENSION, '', $layout) . PHP_FILE_EXTENSION;
            if (!file_exists($layout_file)) {
                Http::setHeader(Http::getValue('SERVER_PROTOCOL') . ' 500 Internal Server Error', true, 500);
                $this->setContent('It seems that "' . str_replace(ROOT_DIR, '', $layout_file) . '" does not exists.');
                $this->send();
            } else {
                require $layout_file;
            }
        } else {
            $default_layout = $this->getDefaultLayout();
            if (file_exists($default_layout)) {
                require $default_layout;
            } else {
                Http::setHeader(Http::getValue('SERVER_PROTOCOL') . ' 500 Internal Server Error', true, 500);
                $this->setContent('It seems that "' . str_replace(ROOT_DIR, '', $default_layout) . '" does not exists.');
                $this->send();
            }
        }
    }

    /**
     * Get action (presentation) content
     *
     * @return bool; whether or not content file exists
     */
    public function getContent()
    {
        $content_view = APPLICATION_PAGE_DIR . Route::getController() . '/' . Route::getAction() . PHP_FILE_EXTENSION;
        if(!file_exists($content_view)) {
            // No verbose
            return false;
        }
        require $content_view;
    }

    /**
     * Get partial (presentation) content
     *
     * @return bool; whether or not partial file exists
     */
    public function getPartial($partial_name)
    {
        $partial_view = APPLICATION_PARTIAL_DIR . $partial_name . PHP_FILE_EXTENSION;
        if(!file_exists($partial_view)) {
            // No verbose
            return false;
        }
        require $partial_view;
    }

    /**
     * Clear output buffer content
     *
     * @return void
     */
    public function clearContent()
    {
        ob_clean();
    }

    /**
     * Print out passed content
     *
     * @return void
     */
    public static function setContent($content = null)
    {
        print($content);
    }

    /**
     * Flush output buffer content
     *
     * @return void
     */
    public function send()
    {
        ob_flush();
    }

    /**
     * Return the default layout path
     *
     * @return string
     */
    private function getDefaultLayout()
    {
        return APPLICATION_LAYOUT_DIR . DEFAULT_LAYOUT . PHP_FILE_EXTENSION;
    }

    /**
     * Enable page cache
     *
     * @return void
     */
    public static function cache()
    {
        self::$cache_page = true;
    }

    /**
     * Return page cache flag
     *
     * @return bool; whether or not to cache output
     */
    public static function cachePage()
    {
        return self::$cache_page;
    }

    /**
     * Check if page cache directory is writable
     * 
     * @return bool; whether or not cache directory is writable
     */
    public static function isPageCacheDirWritable()
    {
        if (is_writable(APPLICATION_PAGE_CACHE_DIR)) {
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
    public static function isPageCached($file)
    {
        $cache_file = APPLICATION_PAGE_CACHE_DIR . $file;
        $cachefile_created = (file_exists($cache_file)) ? @filemtime($cache_file) : 0;
        return ((time() - PAGE_CACHE_EXPIRES) < $cachefile_created);
    }

    /**
     * Read cached file's content
     * 
     * @param File name $file
     * @return string; cache content
     */
    public static function readPageCache($file)
    {
        $cache_file = APPLICATION_PAGE_CACHE_DIR . $file;
        return file_get_contents($cache_file);
    }

    /**
     * Write to cached file
     * 
     * @param File name $file
     * @param Content $out
     * @return void
     */
    public static function writePageCache($file, $out)
    {
        $cache_file = APPLICATION_PAGE_CACHE_DIR . $file;
        $fp = fopen($cache_file, 'w');
        fwrite($fp, $out);
        fclose($fp);
    }    
}
