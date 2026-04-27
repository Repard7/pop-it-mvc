<?php

namespace Validation\Validators;

use Validation\AbstractValidator;

class RequireValidator extends AbstractValidator
{
    protected string $message = 'Field :поле должно быть обязательное';

    public function rule(): bool
    {
        return !empty($this->value) || $this->value === '0';
    }
}