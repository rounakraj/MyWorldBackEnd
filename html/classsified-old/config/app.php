<?php
return [
    /**
     * Debug Level:
     *
     * Production Mode:
     * false: No error messages, errors, or warnings shown.
     *
     * Development Mode:
     * true: Errors and warnings shown.
	 *
     */
    'debug' => false,

    /**
     * Configure basic information about the application.
     *
     * - namespace - The namespace to find app classes under.
     * - encoding - The encoding used for HTML + database connections.
     * - base - The base directory the app resides in. If false this
     *   will be auto detected.
     * - dir - Name of app directory.
     * - webroot - The webroot directory.
     * - wwwRoot - The file path to webroot.
     * - baseUrl - To configure CakePHP to *not* use mod_rewrite and to
     *   use CakePHP pretty URLs, remove these .htaccess
     *   files:
     *      /.htaccess
     *      /webroot/.htaccess
     *   And uncomment the baseUrl key below.
     * - fullBaseUrl - A base URL to use for absolute links.
     * - imageBaseUrl - Web path to the public images directory under webroot.
     * - cssBaseUrl - Web path to the public css directory under webroot.
     * - jsBaseUrl - Web path to the public js directory under webroot.
     * - paths - Configure paths for non class based resources. Supports the
     *   `plugins`, `templates`, `locales` subkeys, which allow the definition of
     *   paths for plugins, view templates and locale files respectively.
     */
    'App' => [
        'namespace' => 'App',
        'encoding' => 'UTF-8',
        'base' => false,
        'dir' => 'src',
        'webroot' => 'webroot',
        'wwwRoot' => WWW_ROOT,
        'adminEmail' => 'oyewebsdeveloper@gmail.com',
		'siteName' => 'KS EDUCATION',
        'siteurl' => 'http://localhost/dharma/new_app/',
        'fullBaseUrl' => false,
        'imageBaseUrl' => 'img/',
        'cssBaseUrl' => 'css/',
        'jsBaseUrl' => 'js/',
        'adminPageLimit' => '15',
		'ProductLimit' => '3',
        'paths' => [
            'plugins' => [ROOT . DS . 'plugins' . DS],
            'templates' => [APP . 'Template' . DS],
            'locales' => [APP . 'Locale' . DS],
        ],
    ],
    
    
    'Security' => [
        'salt' => '9d845c1bedd8e251854a855f7f6593889152b79df3711871deb951422e49118c',
    ],
	
	
   
    'Cache' => [
        'default' => [
            'className' => 'File',
            'path' => CACHE,
        ],

      
        '_cake_core_' => [
            'className' => 'File',
            'prefix' => 'myapp_cake_core_',
            'path' => CACHE . 'persistent/',
            'serialize' => true,
            'duration' => '+2 minutes',
        ],

        '_cake_model_' => [
            'className' => 'File',
            'prefix' => 'myapp_cake_model_',
            'path' => CACHE . 'models/',
            'serialize' => true,
            'duration' => '+2 minutes',
        ],
    ],

  
    'Error' => [
        'errorLevel' => E_ALL & ~E_DEPRECATED,
        'exceptionRenderer' => 'Cake\Error\ExceptionRenderer',
        'skipLog' => [],
        'log' => false,
        'trace' => true,
    ],

  
    'EmailTransport' => [
        'default' => [
            'className' => 'Mail',
			'host' => 'localhost',
            'port' => 25,
            'timeout' => 30,
            'username' => 'user',
            'password' => 'secret',
            'client' => null,
            'tls' => null,
        ],
        'Smtp'=> [
            'transport' => 'Smtp',
            'from' => array('info@kseducation.in' => 'KS Education'),
            'host' => 'smtp.sendgrid.net',
            'port' => 587,
            'timeout' => 60,
            'username' => 'shivram.nmg',
            'password' => 'NMG_2015',
            'client' => null,
            'log' => false,
            'charset' => 'iso-8859-1',
            'mailtype'  => 'html',
            'className' => 'Smtp'
        ],
    ],

  
    'Email' => [
        'default' => [
            'transport' => 'default',
            'from' => 'you@localhost',
             ],
        'Smtp'=> [
            'transport' => 'Smtp',
            'from' => array('info@kseducation.in' => 'KS Education'),
            'host' => 'smtp.sendgrid.net',
            'port' => 587,
            'timeout' => 60,
            'username' => 'shivram.nmg',
            'password' => 'NMG_2015',
            'client' => null,
            'log' => false,
            'charset' => 'iso-8859-1',
            'mailtype'  => 'html',
            'className' => 'Smtp'
        ],
    ],

    'Datasources' => [
        'default' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => 'dharma_app',
            'encoding' => 'utf8',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
            'log' => false,
            'quoteIdentifiers' => false,

        ],

        /**
         * The test connection is used during the test suite.
         */
        'test' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => 'test_myapp',
            'encoding' => 'utf8',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
            'quoteIdentifiers' => false,
            'log' => false,
       
        ],
    ],

    /**
     * Configures logging options
     */
    'Log' => [
        'debug' => [
            'className' => 'Cake\Log\Engine\FileLog',
            'path' => LOGS,
            'file' => 'debug',
            'levels' => ['notice', 'info', 'debug'],
        ],
        'error' => [
            'className' => 'Cake\Log\Engine\FileLog',
            'path' => LOGS,
            'file' => 'error',
            'levels' => ['warning', 'error', 'critical', 'alert', 'emergency'],
        ],
    ],

   
    'Session' => [
        'defaults' => 'php',
		  'timeout'=> 300
    ],
];
