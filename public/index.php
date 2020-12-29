<?php

use tm\core\Router;

$query = substr($_SERVER['REQUEST_URI'], 1);

define('WWW', __DIR__);
define('CORE', dirname(__DIR__) . '/vendor/tm/core');
define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__) . '/app');
define('LAYOUT', 'app');

require '../vendor/tm/libs/functions.php';
require '../vendor/tm/libs/rb.php';
require '../vendor/autoload.php';

$db = require  '../config/database.php';

R::setup( $db['dsn'], $db['user'], $db['pass'] );
R::freeze( TRUE );


Router::add('^$', ['controller' => 'Tasks', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?');

Router::dispatch($query);