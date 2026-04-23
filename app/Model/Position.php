<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public $timestamps = false;
    protected $table = 'Position'; 
    protected $primaryKey = 'position_id';
    protected $fillable = ['position_name'];
    
    public function users()
    {
        return $this->hasMany(User::class, 'position_id', 'position_id');
    }
}