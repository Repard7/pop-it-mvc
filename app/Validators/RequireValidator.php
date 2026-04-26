<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class RequireValidator extends AbstractValidator
{
    protected string $message = 'Field :поле должно быть обязательное';

    public function rule(): bool
    {
        // Проверяем, что значение не пустое и не null
        return !empty($this->value) || $this->value === '0';
    }
}