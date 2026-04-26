<?php

namespace Controller;

use Model\Employee;
use Model\User;
use Model\Position;
use Model\Department;
use Src\View;
use Src\Request;
use Src\Validator\Validator;

class EmployeeController
{
    public function index(): string
    {
        $employees = Employee::with('users.position', 'users.department')->get();
        return (new View('employees.index', ['employees' => $employees]))->render();
    }

    public function add(Request $request): string
    {
        $departments = Department::all();
        
        if ($request->method === 'GET') {
            return (new View('employees.add', ['departments' => $departments]))->render();
        }
        
        $currentUser = app()->auth::user();
        
        // Валидация
        $validator = new Validator($request->all(), [
            'lastname' => ['required', 'name_part'],
            'firstname' => ['required', 'name_part'],
            'middlename' => ['name_part'],
            'gender' => ['required'],
            'birthdate' => ['required'],
            'address' => ['required'],
            'login' => ['required', 'unique:User,login'],
            'password' => ['required']
        ], [
            'required' => 'Поле :field обязательно для заполнения',
            'name_part' => 'Поле :field должно содержать только буквы',
            'unique' => 'Поле :field должно быть уникальным'
        ]);
        
        if ($validator->fails()) {
            return (new View('employees.add', [
                'departments' => $departments,
                'errors' => $validator->errors(),
                'old' => $request->all()
            ]))->render();
        }
        
        $employee = Employee::create([
            'first_name' => $request->firstname,
            'last_name' => $request->lastname,
            'patronymic' => $request->middlename,
            'gender' => $request->gender,
            'birth_date' => $request->birthdate,
            'registration_address' => $request->address
        ]);
        
        if ($currentUser->isAdmin()) {
            $position = Position::where('position_name', 'Сотрудник деканата')->first();
        } else {
            $position = Position::where('position_name', 'Педагогический сотрудник')->first();
        }
        
        User::create([
            'login' => $request->login,
            'password' => password_hash($request->password, PASSWORD_DEFAULT),
            'employee_id' => $employee->employee_id,
            'position_id' => $position->position_id,
            'department_id' => $request->department_id ?: null
        ]);
        
        app()->route->redirect('/employees');
        return '';
    }

    public function edit(Request $request): string
    {
        $employee = Employee::with('users.position', 'users.department')->find($request->id);
        $departments = Department::all();
        
        if (!$employee) {
            app()->route->redirect('/employees');
            return '';
        }
        
        $user = $employee->users->first();
        
        if ($request->method === 'GET') {
            return (new View('employees.edit', [
                'employee' => $employee,
                'user' => $user,
                'departments' => $departments
            ]))->render();
        }
        
        // Валидация для редактирования
        $validator = new Validator($request->all(), [
            'lastname' => ['required', 'name_part'],
            'firstname' => ['required', 'name_part'],
            'middlename' => ['name_part'],
            'gender' => ['required'],
            'birthdate' => ['required'],
            'address' => ['required'],
            'login' => ['required']
        ], [
            'required' => 'Поле :field обязательно для заполнения',
            'name_part' => 'Поле :field должно содержать только буквы'
        ]);
        
        // Проверка уникальности логина (исключая текущего пользователя)
        $existingUser = User::where('login', $request->login)
            ->where('user_id', '!=', $user->user_id)
            ->first();
        
        if ($existingUser) {
            return (new View('employees.edit', [
                'employee' => $employee,
                'user' => $user,
                'departments' => $departments,
                'errors' => ['login' => ['Поле login должно быть уникальным']],
                'old' => $request->all()
            ]))->render();
        }
        
        if ($validator->fails()) {
            return (new View('employees.edit', [
                'employee' => $employee,
                'user' => $user,
                'departments' => $departments,
                'errors' => $validator->errors(),
                'old' => $request->all()
            ]))->render();
        }
        
        $employee->update([
            'first_name' => $request->firstname,
            'last_name' => $request->lastname,
            'patronymic' => $request->middlename,
            'gender' => $request->gender,
            'birth_date' => $request->birthdate,
            'registration_address' => $request->address
        ]);
        
        if ($user) {
            $user->update([
                'login' => $request->login,
                'department_id' => $request->department_id ?: null
            ]);
            
            if (!empty($request->password)) {
                $user->update(['password' => password_hash($request->password, PASSWORD_DEFAULT)]);
            }
        }
        
        app()->route->redirect('/employees');
        return '';
    }

    public function delete(Request $request): void
    {
        $employee = Employee::find($request->id);
        if ($employee) {
            if ($user = $employee->users->first()) {
                $user->delete();
            }
            $employee->delete();
        }
        app()->route->redirect('/employees');
    }
}