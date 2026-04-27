<?php

namespace Validators;

use Illuminate\Database\Capsule\Manager as Capsule;
use Validation\AbstractValidator;

class UniqueValidator extends AbstractValidator
{
    protected string $message = 'Field :field must be unique';

    public function rule(): bool
    {
        $table = $this->args[0] ?? '';
        $field = $this->args[1] ?? '';
        
        if (empty($table) || empty($field)) {
            return true;
        }
        
        $count = Capsule::table($table)
            ->where($field, $this->value)
            ->count();
        
        return $count == 0;
    }
}