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
            return (new View('disciplines.add', [
                'departments' => $departments
            ]))->render();
        }
        
        // Создаем дисциплину со ВСЕМИ полями
        $discipline = Discipline::create([
            'discipline_name' => $request->name,
            'hours' => $request->hours,
            'semester' => $request->semester
        ]);
        
        // Привязываем выбранные кафедры
        $discipline->departments()->attach($request->department_ids ?? []);
        
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

    public function edit(Request $request): string
    {
        $discipline = Discipline::with('departments')->find($request->id);
        
        if (!$discipline) {
            app()->route->redirect('/disciplines');
            return '';
        }
        
        if ($request->method === 'GET') {
            $departments = Department::all();
            return (new View('disciplines.edit', [
                'discipline' => $discipline,
                'departments' => $departments
            ]))->render();
        }
        
        // POST: обновляем название дисциплины
        $discipline->update([
            'discipline_name' => $request->name
        ]);
        
        // Обновляем связи с кафедрами (sync сам удалит старые и добавит новые)
        $discipline->departments()->sync($request->department_ids ?? []);
        
        app()->route->redirect('/disciplines');
        return '';
    }
}