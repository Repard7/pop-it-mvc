<?php

namespace Controller;

use Model\Department;
use Src\View;
use Src\Request;

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
        
        // Создание кафедры с кодом
        Department::create([
            'department_name' => $request->name,
            'code' => $request->code
        ]);
        
        app()->route->redirect('/departments');
        return '';
    }

    public function delete(Request $request): void
    {
        $department = Department::find($request->id);
        $department->disciplines()->detach();
        $department->delete();
        app()->route->redirect('/departments');
    }
}