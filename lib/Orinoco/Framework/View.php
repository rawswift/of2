<?php
/**
 * Orinoco Framework - A lightweight PHP framework.
 *  
 * Copyright (c) 2008-2013 Ryan Yonzon, http://www.ryanyonzon.com/
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 */

namespace Orinoco\Framework;

class View
{
    /**
     * Inherit controller object's variables on-fly, make them visible to the presentation layers
     *
     * @param Controller object $obj
     * @return void
     */
    public function prepareView($obj)
    {
        foreach($obj as $k => $v) {
            $this->$k = $v;
        }
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
     * Render presentation (action) content
     *
     * @return bool; whether or not content file exists
     */
    public function renderContent()
    {
        $content_view = APPLICATION_PAGE_DIR . $this->getController() . '/' . $this->getAction() . PHP_FILE_EXTENSION;
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
}
