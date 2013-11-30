<?php

use Orinoco\Framework\Http;
use Orinoco\Framework\View;

class foo
{
    public function __construct()
    {
        // you can optionally set the view template to use here, e.g.:
        // $this->layout = 'foo';
        // the above example will render the file app/views/layouts/foo.php
        // else the framework will find and render app/views/layouts/default.php, instead.
    }

    // this will be the function that'll be executed when you go to the URI: /foo
    public function index()
    {
        // nothing to do here.
        // see view/page/foo/index.php (view template)
    }

    // this will be the function that'll be executed when you go to the URI: /foo/bar
    public function bar()
    {
        // nothing to do here.
        // see view/page/foo/bar.php (view template)
    }

    // sample JSON response, using Http and View classes
    public function json()
    {
        $json = json_encode(array(
                'ok' => true,
                'message' => 'Hello World!'
            ));
        Http::setHeader(array(
                'Content-Length' => strlen($json),
                'Content-type' => 'application/json;'
            ));
        // skip HTML views (templates)
        View::disable();
        // ...and just render the JSON object
        View::setContent($json);
    }
}
