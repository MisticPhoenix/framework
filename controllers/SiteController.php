<?php

namespace App\controllers;

use App\core\Application;
use App\core\Controller;
use App\core\Request;

class SiteController extends Controller
{
    public function home(): false|string
    {
        $params = [
            'name' => !Application::isGuest() ? Application::$app->user->firstName : 'anonymous'
        ];
        return $this->render('home', $params);
    }

    public function handleContact(Request $request): string
    {
        $request->getBody();
        return '321';
    }
}