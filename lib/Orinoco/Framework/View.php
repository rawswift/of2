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
    // whether or not to render view/template (HTML layout and HTML contents)
    public static $view_enabled = true;

    /**
     * Disable view/template rendering
     *
     * @return void
     */
    public function disable()
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
     * Render presentation layout
     *
     * @return void
     */
    public function renderLayout()
    {
        // check if $layout variable is set
        if(isset($this->layout)) {
            $layout_file = APPLICATION_LAYOUT_DIR . str_replace(PHP_FILE_EXTENSION, '', $this->layout) . PHP_FILE_EXTENSION;
            if (!file_exists($layout_file)) {
                Http::setHeader('Status: 200');
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
                Http::setHeader('Status: 200');
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
    public function setContent($content = null)
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
     * Check if page cache directory is writable
     * 
     * @return bool; whether or not cache directory is writable
     */
    public function isPageCacheDirWritable()
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
    public function isPageCached($file)
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
    public function readPageCache($file)
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
    public function writePageCache($file, $out)
    {
        $cache_file = APPLICATION_PAGE_CACHE_DIR . $file;
        $fp = fopen($cache_file, 'w');
        fwrite($fp, $out);
        fclose($fp);
    }    
}
