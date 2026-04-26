<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class NamePartValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно содержать только буквы и дефис';

    public function rule(): bool
    {
        if (empty($this->value)) {
            return true; // пустое поле проверит required
        }
        
        // Только буквы (русские/английские) и дефис (для двойных фамилий типа "Салтыков-Щедрин")
        return (bool)preg_match('/^[a-zA-Zа-яА-ЯёЁ]+$/u', $this->value);
    }
}