<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public $timestamps = false;
    protected $table = 'Department'; 
    protected $primaryKey = 'department_id';
    protected $fillable = ['department_name', 'code'];
    
    public function disciplines()
    {
        return $this->belongsToMany(
            Discipline::class,
            'Department_Discipline',
            'department_id',
            'discipline_id'
        );
    }
}