<?php

namespace Controller;

use Model\Employee;
use Model\User;
use Model\Position;
use Model\Department;
use Src\View;
use Src\Request;

class EmployeeController
{
    public function index(): string
    {
        $employees = Employee::with('users.position', 'users.department')->get();
        $view = new View('employees.index', ['employees' => $employees]);
        return $view->render();
    }

    public function add(Request $request): string
    {
        $currentUser = app()->auth::user();
        
        // Если GET — показываем форму с данными для select'ов
        if ($request->method === 'GET') {
            $departments = Department::all();
            $positions = Position::all();
            return (new View('employees.add', [
                'departments' => $departments,
                'positions' => $positions
            ]))->render();
        }
        
        // Если POST — сохраняем
        
        // 1. Создаем запись о сотруднике
        $employee = Employee::create([
            'first_name' => $request->firstname,
            'last_name' => $request->lastname,
            'patronymic' => $request->middlename,
            'gender' => $request->gender, // Теперь приходит 'М' или 'Ж'
            'birth_date' => $request->birthdate,
            'registration_address' => $request->address
        ]);
        
        // 2. Хешируем пароль
        $hashedPassword = password_hash($request->password, PASSWORD_DEFAULT);
        
        // 3. Создаем запись пользователя
        User::create([
            'login' => $request->login,
            'password' => $hashedPassword,
            'employee_id' => $employee->employee_id,
            'position_id' => $request->position_id, // Берем из формы
            'department_id' => $request->department_id ?: null
        ]);
        
        app()->route->redirect('/employees');
        return '';
    }

    public function delete(Request $request): void
    {
        $employee = Employee::find($request->id);
         if ($employee) {
            $user = $employee->users->first();
            if ($user) {
                $user->delete();
            }
            $employee->delete();
        }
        app()->route->redirect('/employees');
    }
}