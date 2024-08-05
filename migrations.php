<?php
//ctrl+alt+l

require_once __DIR__ . '/vendor/autoload.php';

use App\controllers\SiteController;
use App\core\Application;

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
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

$app->db->applyMigrations();