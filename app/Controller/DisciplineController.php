<?php

namespace Controller;

use Model\Discipline;
use Model\Department;
use Src\View;
use Src\Request;

use Validation\Validator;
use Validation\Validators\RequireValidator;
use Validation\Validators\MinArrayValidator;

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
        
        $departmentIds = [];
        if (isset($_POST['department_ids']) && is_array($_POST['department_ids'])) {
            $departmentIds = $_POST['department_ids'];
        }
        
        $departmentIds = array_filter($departmentIds, function($id) {
            return !empty($id) && is_numeric($id);
        });
        $departmentIds = array_map('intval', $departmentIds);
        
        $data = $request->all();
        $data['department_ids'] = $departmentIds;
        
        $rules = [
            'name' => ['required'],
            'hours' => ['required'],
            'semester' => ['required'],
            'department_ids' => ['min_array:1']
        ];

        $messages = [
            'name.required' => 'Название дисциплины обязательно',
            'hours.required' => 'Количество часов обязательно',
            'semester.required' => 'Семестр обязателен',
            'department_ids.min_array' => 'Выберите хотя бы одну кафедру',
        ];

        $validator = new Validator($data, $rules, $messages, [
            'required'  => RequireValidator::class,
            'min_array' => MinArrayValidator::class
        ]);
        
        if ($validator->fails()) {
            $fieldNames = [
                'name' => 'Название дисциплины',
                'hours' => 'Учебные часы',
                'semester' => 'Семестр',
            ];
            return (new View('disciplines.add', [
                'departments' => $departments,
                'errors' => $validator->errors(),
                'old' => $request->all(),
                'fieldNames' => $fieldNames,
            ]))->render();
        }
        
        $discipline = Discipline::create([
            'discipline_name' => $request->name,
            'hours' => $request->hours,
            'semester' => $request->semester
        ]);
        
        $discipline->departments()->sync($departmentIds);
        
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
        
        $departmentIds = [];
        if (isset($_POST['department_ids']) && is_array($_POST['department_ids'])) {
            $departmentIds = $_POST['department_ids'];
        }
        
        $departmentIds = array_filter($departmentIds, function($id) {
            return !empty($id) && is_numeric($id);
        });
        $departmentIds = array_map('intval', $departmentIds);
        
        $data = $request->all();
        $data['department_ids'] = $departmentIds;
        
        $rules = [
            'name' => ['required'],
            'hours' => ['required'],
            'semester' => ['required'],
            'department_ids' => ['min_array:1']
        ];

        $messages = [
            'name.required' => 'Название дисциплины обязательно',
            'hours.required' => 'Количество часов обязательно',
            'semester.required' => 'Семестр обязателен',
            'department_ids.min_array' => 'Выберите хотя бы одну кафедру',
        ];

        $validator = new Validator($data, $rules, $messages, [
            'required'  => RequireValidator::class,
            'min_array' => MinArrayValidator::class
        ]);
        
        if ($validator->fails()) {
            $fieldNames = [
                'name' => 'Название дисциплины',
                'hours' => 'Учебные часы',
                'semester' => 'Семестр',
            ];
            return (new View('disciplines.edit', [
                'discipline' => $discipline,
                'departments' => $departments,
                'errors' => $validator->errors(),
                'old' => $request->all(),
                'fieldNames' => $fieldNames
            ]))->render();
        }
        
        $discipline->update([
            'discipline_name' => $request->name,
            'hours' => $request->hours,
            'semester' => $request->semester
        ]);
        
        $discipline->departments()->sync($departmentIds);
        
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