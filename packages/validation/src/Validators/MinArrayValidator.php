<?php

namespace Validation\Validators;

use Validation\AbstractValidator;

class MinArrayValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно содержать минимум :min элементов';

    public function rule(): bool
    {
        if (!is_array($this->value)) {
            return false;
        }
        
        $min = (int)($this->args[0] ?? 1);
        return count($this->value) >= $min;
    }
    
    protected function messageError(): string
    {
        $message = $this->message;
        
        $min = $this->args[0] ?? 1;
        $message = str_replace(':min', $min, $message);
        
        foreach ($this->messageKeys as $key => $value) {
            $message = str_replace($key, (string)$value, $message);
        }
        
        return $message;
    }
}