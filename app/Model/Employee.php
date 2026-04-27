<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamps = false;
    protected $table = 'employee'; 
    protected $primaryKey = 'employee_id';
    protected $fillable = [
        'first_name', 'last_name', 'patronymic',
        'gender', 'birth_date', 'registration_address'
    ];
    
    public function users()
    {
        return $this->hasMany(User::class, 'employee_id', 'employee_id');
    }
}