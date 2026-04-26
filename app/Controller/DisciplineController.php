<?php

namespace Controller;

use Model\Discipline;
use Model\Department;
use Src\View;
use Src\Request;

use Validation\Validator;
use Validation\Validators\RequireValidator;

class DisciplineController
{
    public function index(): string
    {
        $disciplines = Discipline::with('departments')->get();
        return (new View('disciplines.index', ['disciplines' => $disciplines]))->render();
    }
    
    public function add(Request $request): string
    {
        $departments = Department::all();
        
        if ($request->method === 'GET') {
            return (new View('disciplines.add', ['departments' => $departments]))->render();
        }
        
        $validator = new Validator($request->all(), [
            'name' => ['required'],
            'hours' => ['required'],
            'semester' => ['required']
        ], [
            'required' => 'Поле :field обязательно для заполнения'
        ], [
            'required' => RequireValidator::class
        ]);
        
        if ($validator->fails()) {
            return (new View('disciplines.add', [
                'departments' => $departments,
                'errors' => $validator->errors(),
                'old' => $request->all()
            ]))->render();
        }
        
        $discipline = Discipline::create([
            'discipline_name' => $request->name,
            'hours' => $request->hours,
            'semester' => $request->semester
        ]);
        
        if (!empty($request->department_ids) && is_array($request->department_ids)) {
            $discipline->departments()->attach($request->department_ids);
        }
        
        app()->route->redirect('/disciplines');
        return '';
    }

    public function edit(Request $request): string
    {
        $discipline = Discipline::with('departments')->find($request->id);
        $departments = Department::all();
        
        if (!$discipline) {
            app()->route->redirect('/disciplines');
            return '';
        }
        
        if ($request->method === 'GET') {
            return (new View('disciplines.edit', [
                'discipline' => $discipline,
                'departments' => $departments
            ]))->render();
        }
        
        $validator = new Validator($request->all(), [
            'name' => ['required'],
            'hours' => ['required'],
            'semester' => ['required']
        ], [
            'required' => 'Поле :field обязательно для заполнения'
        ], [
            'required' => RequireValidator::class  // ← ЭТОЙ СТРОКИ НЕ ХВАТАЛО
        ]);
        
        if ($validator->fails()) {
            return (new View('disciplines.edit', [
                'discipline' => $discipline,
                'departments' => $departments,
                'errors' => $validator->errors(),
                'old' => $request->all()
            ]))->render();
        }
        
        $discipline->update([
            'discipline_name' => $request->name,
            'hours' => $request->hours,
            'semester' => $request->semester
        ]);
        
        $discipline->departments()->sync($request->department_ids ?? []);
        
        app()->route->redirect('/disciplines');
        return '';
    }

    public function delete(Request $request): void
    {
        $discipline = Discipline::find($request->id);
        if ($discipline) {
            $discipline->departments()->detach();
            $discipline->delete();
        }
        app()->route->redirect('/disciplines');
    }
}