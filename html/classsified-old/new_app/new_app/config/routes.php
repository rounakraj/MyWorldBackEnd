<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\Router;
use Cake\Routing\RequestActionTrait;
/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
 

Router::defaultRouteClass('DashedRoute');

Router::scope('/', function ($routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/index.html', ['controller' => 'Pages', 'action' => 'home']);
	$routes->connect('/question_bank.html', ['controller' => 'Products', 'action' => 'index',2]);
	$routes->connect('/books.html', ['controller' => 'Products', 'action' => 'index']);
	$routes->connect('/news.html', ['controller' => 'News', 'action' => 'index']);
	$routes->connect('/mock_test.html', ['controller' => 'Products', 'action' => 'quizs']);
	$routes->connect('/', ['controller' => 'Pages', 'action' => 'home']);
	$routes->connect('/contact.html', ['controller' => 'Pages', 'action' => 'contactus']);
    //$routes->connect('/',  ['controller' => 'Admins', 'action' => 'login']);
    $routes->connect('/fblogin.html', array('controller' => 'users', 'action' => 'fblogin' ));
	$routes->connect('/fbslogin', array('controller' => 'users', 'action' => 'fbslogin' ));
	
	$routes->connect('/googlelogin', array('controller' => 'users', 'action' => 'googlelogin' ));
	$routes->connect('/glogin.html', array('controller' => 'users', 'action' => 'glogin' ));
	
	
	$routes->connect('/dashboard.html', ['controller' => 'Users', 'action' => 'dashboard']);
	$routes->connect('/forgotpassword.html', ['controller' => 'Users', 'action' => 'forgotpassword']);
	$routes->connect('/logout.html', ['controller' => 'Users', 'action' => 'logout']);
	$routes->connect('/editprofile.html', ['controller' => 'Users', 'action' => 'editprofile']);
	$routes->connect('/login.html', ['controller' => 'Users', 'action' => 'login']);
	$routes->connect('/register.html', ['controller' => 'Users', 'action' => 'register']);
	
	$routes->connect('/question.html', ['controller' => 'Users', 'action' => 'question']);
	$routes->connect('/ebook.html', ['controller' => 'Users', 'action' => 'ebook']);
	$routes->connect('/mockuptest.html', ['controller' => 'Users', 'action' => 'mockuptest']);
	$routes->connect('/mockup_result.html', ['controller' => 'Products', 'action' => 'result']);
	
	$routes->connect('/webservice.jsp', ['controller' => 'Webservices', 'action' => 'index']);
	
	$routes->connect(
       '/:slug.html',
        ['controller' => 'Pages', 'action' => 'view'],
        [
            'pass' => ['slug']
        ]
    );
	
	
	$routes->connect(
       '/product:id.html',
        ['controller' => 'Products', 'action' => 'view'],
        [
            'pass' => ['id'],
             'id' => '[0-9]+'
        ]
    );
	
	$routes->connect(
       '/checkout:id.html',
        ['controller' => 'Products', 'action' => 'checkout'],
        [
            'pass' => ['id'],
             'id' => '[0-9]+'
        ]
    );
	
	$routes->connect(
       '/quizsview:id.html',
        ['controller' => 'Products', 'action' => 'quizsview'],
        [
            'pass' => ['id'],
             'id' => '[0-9]+'
        ]
    );
	$routes->connect(
       '/orderquiz:id.html',
        ['controller' => 'Products', 'action' => 'orderquiz'],
        [
            'pass' => ['id'],
             'id' => '[0-9]+'
        ]
    );
	
	$routes->connect(
       '/news:id.html',
        ['controller' => 'News', 'action' => 'view'],
        [
            'pass' => ['id'],
             'id' => '[0-9]+'
        ]
    );
	
	$routes->connect(
       '/newscat:id.html',
        ['controller' => 'News', 'action' => 'index'],
        [
            'pass' => ['id'],
             'id' => '[0-9]+'
        ]
    );
	
	
	
	$routes->connect(
       '/category:id.html',
        ['controller' => 'Products', 'action' => 'category'],
        [
            'pass' => ['id'],
             'id' => '[0-9]+'
        ]
    );
	
	
	
   

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
   
    $routes->connect("/:controller/:action/*");
    //$routes->connect('/admin/', ['controller' => 'Admins', 'action' => 'login']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks('DashedRoute');
});

 Router::prefix('admin',function($routes) {
	// Because you are in the admin scope,
	// you do not need to include the /admin prefix
	// or the admin route element.
    $routes->connect('/', ['controller' => 'Admins', 'action' => 'login']);
    $routes->connect('/logout', ['controller' => 'Admins', 'action' => 'logout']);
    $routes->connect('/dashboard', ['controller' => 'Admins', 'action' => 'dashboard']);
    $routes->connect('/index', ['controller' => 'Admins', 'action' => 'index']);
    $routes->connect('/edit', ['controller' => 'Admins', 'action' => 'edit']);
    $routes->connect('/changepassword', ['controller' => 'Admins', 'action' => 'changepassword']);
    $routes->connect('/master', ['controller' => 'Admins', 'action' => 'master']);
    $routes->connect("/:controller/:action/*");
    
	//$routes->fallbacks('DashedRoute');
	//$routes->fallbacks('DashedRoute');
});
 
 
Router::prefix('api',function($routes) {
    $routes->connect("/:controller/:action/*");
});
/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();

