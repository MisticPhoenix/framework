<?php

namespace App;

use App\core\Application;

class View
{
    public string $title = '';
    public function renderView($view, $params = []): string|false
    {
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    private function layoutContent(): string|false
    {
        $layout = Application::$app->controller->getLayout();
        ob_start();
        include_once Application::getROOT_DIR() . "/../views/layouts/$layout.php";
        return ob_get_clean();
    }

    private function renderOnlyView($view, $params): string|false
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::getROOT_DIR() . "/../views/$view.php";
        return ob_get_clean();
    }
}