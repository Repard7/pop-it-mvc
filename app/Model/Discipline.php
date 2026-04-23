<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    public $timestamps = false;
    protected $table = 'Discipline'; 
    protected $primaryKey = 'discipline_id';
    protected $fillable = ['discipline_name', 'hours', 'semester'];
    
    public function departments()
    {
        return $this->belongsToMany(
            Department::class,
            'Department_Discipline',
            'discipline_id',
            'department_id'
        );
    }
}