<?php

namespace Validation\Validators;

use Validation\AbstractValidator;

class RequireValidator extends AbstractValidator
{
    protected string $message = 'Поле :field обязательно для заполнения';

    public function rule(): bool
    {
        return !empty($this->value) || $this->value === '0';
    }
}