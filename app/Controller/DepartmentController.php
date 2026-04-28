<?php

namespace Controller;

use Model\Department;
use Src\View;
use Src\Request;

use Validation\Validator;
use Validation\Validators\RequireValidator;
use Validation\Validators\UniqueValidator;


class DepartmentController
{
    public function index(): string
    {
        $departments = Department::with('disciplines')->get();
        return (new View('departments.index', ['departments' => $departments]))->render();
    }

    public function add(Request $request): string
    {
        if ($request->method === 'GET') {
            return (new View('departments.add'))->render();
        }
        
        $validator = new Validator($request->all(), [
            'name' => ['required'],
            'code' => ['required', 'unique:Department,code']
        ], [
            'required' => 'Поле :field обязательно для заполнения',
            'unique' => 'Кафедра с таким кодом уже существует'
        ], [
            'required' => RequireValidator::class,
            'unique' => UniqueValidator::class
        ]);
        
        if ($validator->fails()) {
            return (new View('departments.add', [
                'errors' => $validator->errors(),
                'old' => $request->all()
            ]))->render();
        }
        
        Department::create([
            'department_name' => $request->name,
            'code' => $request->code
        ]);
        
        app()->route->redirect('/departments');
        return '';
    }

    public function edit(Request $request): string
    {
        $department = Department::find($request->id);
        
        if (!$department) {
            app()->route->redirect('/departments');
            return '';
        }
        
        if ($request->method === 'GET') {
            return (new View('departments.edit', ['department' => $department]))->render();
        }
        
        $validator = new Validator($request->all(), [
            'name' => ['required'],
            'code' => ['required']
        ], [
            'required' => 'Поле :field обязательно для заполнения'
        ], [
            'required' => RequireValidator::class
        ]);
        
        $existingDept = Department::where('code', $request->code)
            ->where('department_id', '!=', $department->department_id)
            ->first();
        
        if ($existingDept) {
            return (new View('departments.edit', [
                'department' => $department,
                'errors' => ['code' => ['Кафедра с таким кодом уже существует']],
                'old' => $request->all()
            ]))->render();
        }
        
        if ($validator->fails()) {
            return (new View('departments.edit', [
                'department' => $department,
                'errors' => $validator->errors(),
                'old' => $request->all()
            ]))->render();
        }
        
        $department->update([
            'department_name' => $request->name,
            'code' => $request->code
        ]);
        
        app()->route->redirect('/departments');
        return '';
    }

    public function delete(Request $request): void
    {
        $department = Department::find($request->id);
        if ($department) {
            $department->disciplines()->detach();
            $department->delete();
        }
        app()->route->redirect('/departments');
    }
}