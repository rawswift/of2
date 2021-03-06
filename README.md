# Orinoco Framework 2

## NOTICE: This project is unmaintained and outdated. For the latest and updated source, please go to [GitHub/orinoco-framework-php](https://github.com/rawswift/orinoco-framework-php).

A lightweight PHP framework.

## Quick Glance

### Basic Controller

    <?php

    class foo
    {
            public function index()
            {
                    // executed on request URI /foo
            }

            public function bar()
            {
                    // executed on request URI /foo/bar
            }
    }

### Advance Controller

    <?php

    // use framework's classes
    use Orinoco\Framework\Http;
    use Orinoco\Framework\View;

    // use Monolog vendor (installed via Composer)
    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;

    class log
    {
            public function index()
            {
                    // create a log channel
                    $log = new Logger('name');
                    $log->pushHandler(new StreamHandler('/tmp/monolog.txt', Logger::WARNING));

                    // add records to the log
                    $log->addWarning('Foo');
                    $log->addError('Bar');

                    // assuming everything went OK
                    $json = json_encode(array(
                            'ok' => true,
                            'message' => 'Log written successfully.'
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

## Requirement

Orinoco Framework 2 requires PHP 5.3.3 or later.

## Installation

1. Clone framework source:

        $ mkdir myapp
        $ git clone git://github.com/rawswift/of2.git myapp/

2. Setup virtual host: (remember to point `root` to `myapp/app/web`)

        server {
                listen      80;
                server_name myapp.com;
                access_log  /var/log/nginx/myapp.com.access.log;
                error_log   /var/log/nginx/myapp.com.error.log;
                rewrite_log on;
                root        /path/to/myapp/app/web;
                index       index.php;
                if (!-e $request_filename) {
                        rewrite ^/(.+)$ /index.php last;
                        break;
                }
                location ~ \.php$ {
                        fastcgi_pass   127.0.0.1:9000;
                        fastcgi_index  index.php;
                        fastcgi_intercept_errors on; # to support 404s for PHP files not found
                        fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
                        client_max_body_size 20M;
                        include        fastcgi_params;
                }
                location ~* \favicon.ico$ {
                        access_log off;
                        expires 1d;
                        add_header Cache-Control public;
                }
                location ~ ^/(img|cjs|ccss)/ {
                        access_log off;
                        expires 7d;
                        add_header Cache-Control public;
                }
                 location ~ /(\.ht|\.git|\.svn) {
                        deny  all;
                }
        }

## License

Licensed under the [MIT license](http://www.opensource.org/licenses/mit-license.php)