<?php

namespace App\core;

abstract class Model
{
    protected const RULE_REQUIRED = "required";
    protected const RULE_EMAIL = "email";
    protected const RULE_MIN = "min";
    protected const RULE_MAX = "max";
    protected const RULE_MATCH = "match";
    protected const RULE_UNIQUE = "unique";

    public function loadData($data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    abstract protected function rules(): array;

    private array $errors = [];

    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorForRule($attribute, $this->errorMessages()[self::RULE_REQUIRED]);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRule($attribute, $this->errorMessages()[self::RULE_EMAIL]);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorForRule($attribute, $this->errorMessages()[self::RULE_MIN]);
                }

                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addErrorForRule($attribute, $this->errorMessages()[self::RULE_MAX]);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addErrorForRule($attribute, $this->errorMessages()[self::RULE_MATCH]);
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttribute = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttribute = :attribute");
                    $statement->bindValue(":attribute", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if ($record) {
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, ['field' => $attribute]);
                    }
                }
            }
        }

        return empty($this->errors);
    }

    protected function addErrorForRule(string $attribute, string $message): void
    {
        $this->errors[$attribute][] = $message;
    }

    private function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'The length of this field is too small',
            self::RULE_MAX => 'The length of this field is too big',
            self::RULE_MATCH => 'The fields dont match',
            self::RULE_UNIQUE => 'This email is already in use'
        ];
    }

    public function hasError($attribute): array|false
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute): string|false
    {
        return $this->errors[$attribute][0] ?? false;
    }
}