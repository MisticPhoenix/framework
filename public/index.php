<?php
//ctrl+alt+l

require_once __DIR__ . '/../vendor/autoload.php';

use App\core\Application;

$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


$config = [
    'userClass' => \App\models\User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ]
];

$app = new Application(__DIR__, $config);
$app->router->get('/', [\App\controllers\SiteController::class, 'home']);
$app->router->get('/contact', 'contact');
$app->router->post('/contact', [\App\controllers\SiteController::class, 'handleContact']);

$app->router->get('/login', [\App\controllers\AuthController::class, 'login']);
$app->router->post('/login', [\App\controllers\AuthController::class, 'login']);
$app->router->get('/register', [\App\controllers\AuthController::class, 'register']);
$app->router->post('/register', [\App\controllers\AuthController::class, 'register']);
$app->router->get('/logout', [\App\controllers\AuthController::class, 'logout']);
$app->router->get('/profile', [\App\controllers\AuthController::class, 'profile']);


$app->run();