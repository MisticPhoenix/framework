<?php

namespace App\models;

use App\core\Application;
use App\core\Model;
use App\core\Response;

class LoginForm extends Model
{
    private string $email = '';
    private string $password = '';

    protected function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 32]]
        ];
    }

    public function login(): bool
    {
        $user = User::findOne(['email' => $this->email]);
        if (!$user) {
            $this->addErrorForRule('email', 'User does not exist with this email');
            return false;
        }
        if(!password_verify($this->password, $user->password)) {
            $this->addErrorForRule('password', 'This email or password is incorrect');
            return false;
        }

        return Application::$app->login($user);
    }
}