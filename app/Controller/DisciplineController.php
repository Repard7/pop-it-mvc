<?php

namespace Controller;

use Model\Discipline;
use Model\Department;
use Src\View;
use Src\Request;

class DisciplineController
{
    public function index(): string
    {
        $disciplines = Discipline::with('departments')->get();
        return (new View('disciplines.index', ['disciplines' => $disciplines]))->render();
    }

    public function add(Request $request): string
    {
        if ($request->method === 'GET') {
            $departments = Department::all();
            return (new View('disciplines.add', ['departments' => $departments]))->render();
        }
        
        // Создание дисциплины с новыми полями
        $discipline = Discipline::create([
            'discipline_name' => $request->name,
            'hours' => $request->hours,
            'semester' => $request->semester
        ]);
        
        // Привязка к кафедре (если выбрана)
        if ($request->department_id) {
            $discipline->departments()->attach($request->department_id);
        }
        
        app()->route->redirect('/disciplines');
        return '';
    }

    public function delete(Request $request): void
    {
        $discipline = Discipline::find($request->id);
        $discipline->departments()->detach();
        $discipline->delete();
        app()->route->redirect('/disciplines');
    }
}