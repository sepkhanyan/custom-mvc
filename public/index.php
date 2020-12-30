<?php

use tm\core\Router;
use RedBeanPHP\R;

$query = substr($_SERVER['REQUEST_URI'], 1);

define('CORE', dirname(__DIR__) . '/vendor/tm/core');
define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__) . '/app');
define('LAYOUT', 'app');

require '../vendor/tm/libs/functions.php';
require '../vendor/tm/libs/rb.php';
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$db = [
    'dsn' => $_ENV['DB_DSN'],
    'user' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD'],
];

R::setup( $db['dsn'], $db['user'], $db['password'] );
$admin = R::load( 'users', '1' );
if(!$admin['login']){
    $users = R::dispense( 'users' );
    $users['login'] = 'admin';
    $users['password'] = password_hash('123', PASSWORD_DEFAULT);
    $id = R::store( $users );
}

$tasks = R::getAll('SELECT * FROM tasks');
if(!count($tasks)){
    $rs = new \BenMajor\RedSeed\RedSeed();
    $tasks = $rs->seed('tasks', 3, [
        'performer' => 'word(3,10)',
        'email' => 'email()',
        'description' => function() { return 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'; },
        'status' => function() { return 0; },
        'edited' => function() { return 0; }
    ]);
}
R::freeze();


Router::add('^$', ['controller' => 'Tasks', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?');

Router::dispatch($query);