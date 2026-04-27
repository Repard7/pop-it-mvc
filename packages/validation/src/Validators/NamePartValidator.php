<?php

namespace Validation\Validators;

use Validation\AbstractValidator;

class NamePartValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно содержать только буквы и дефис';

    public function rule(): bool
    {
        if (empty($this->value)) {
            return true;
        }
        
        return (bool)preg_match('/^[a-zA-Zа-яА-ЯёЁ]+$/u', $this->value);
    }
}