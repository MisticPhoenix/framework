<?php

namespace App\core;

use App\core\middlewares\BaseMiddleware;

class Controller
{
    private string $layout = 'main';
    public string $action = '';

    /**
     * @var BaseMiddleware[]
     * */
    protected array $middlewares = [];

    public function getLayout(): string
    {
        return $this->layout;
    }

    public function setLayout($layout): void
    {
        $this->layout = $layout;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    protected function render($view, $params = []): false|string
    {
        return Application::$app->view->renderView($view, $params);
    }

    protected function registerMiddleware(BaseMiddleware $middleware): void
    {
        $this->middlewares[] = $middleware;
    }
}