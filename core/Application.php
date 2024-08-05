<?php

namespace App\core;

use App\core\db\DataBase;
use App\core\db\DbModel;
use App\View;
use mysql_xdevapi\Statement;

class Application
{
    private static string $ROOT_DIR;

    public readonly Router $router;
    private readonly Request $request;
    public readonly DataBase $db;
    public readonly Response $response;
    public Controller $controller;
    public Session $session;
    public static Application $app;
    public ?DbModel $user;
    public View $view;
    protected string $userClass;

    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$app = $this;
        self::$ROOT_DIR = $rootPath;
        $this->controller = new Controller();
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->view = new View();
        $this->router = new Router($this->request, $this->response);
        $this->db = new DataBase($config['db']);

        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public static function getROOT_DIR(): string
    {
        return self::$ROOT_DIR;
    }

    public function run(): void
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $ex) {
            $this->response->setStatusCode(404);
            echo $this->view->renderView('_error', [
                'exception' => $ex
            ]);
        }
    }

    public function login(DbModel $user): bool
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);

        return true;
    }

    public function logout(): void
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest(): bool
    {
        return !self::$app->user;
    }
}