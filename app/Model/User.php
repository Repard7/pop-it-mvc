<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class User extends Model implements IdentityInterface
{
    use HasFactory;

    protected $table = 'user';
    public $timestamps = false;
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'login', 'password', 'employee_id', 'position_id', 'department_id'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }
    
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'position_id');
    }
    
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }
    
   protected static function booted()
   {
       static::created(function ($user) {
           $user->password = md5($user->password);
           $user->save();
       });
   }

    public function findIdentity(int $id)
    {
        return self::with(['employee', 'position', 'department'])
            ->where('user_id', $id)
            ->first();
    }

   //Возврат первичного ключа
    public function getId(): int
    {
        return $this->user_id;
    }

   //Возврат аутентифицированного пользователя
    public function attemptIdentity(array $credentials)
    {
        return self::with(['employee', 'position', 'department'])
            ->where([
                'login' => $credentials['login'],
                'password' => md5($credentials['password'])
            ])
            ->first();
    }

    public function isAdmin(): bool
    {
        return $this->position && $this->position->position_name === 'Администратор';
    }

    public function isDeaneryStaff(): bool
    {
        return $this->position && $this->position->position_name === 'Сотрудник деканата';
    }

    public function isTeachingStaff(): bool
    {
        return $this->position && $this->position->position_name === 'Педагогический сотрудник';
    }

    public function canCreateDepartment(): bool
    {
        return $this->isDeaneryStaff();
    }

    public function canCreateDiscipline(): bool
    {
        return $this->isDeaneryStaff();
    }

    public function canCreateEmployee(): bool
    {
        return $this->isAdmin() || $this->isDeaneryStaff();
    }

    public function canView(): bool
    {
        return $this->isAdmin() || $this->isDeaneryStaff() || $this->isTeachingStaff();
    }

}
