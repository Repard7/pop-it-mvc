<?php

use Src\Route;

Route::add(['GET'], '/', [Controller\Site::class, 'index'])->middleware('auth');

Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

// Сотрудники
Route::add('GET', '/employees', [Controller\EmployeeController::class, 'index'])->middleware('auth');
Route::add(['GET', 'POST'], '/employees/add', [Controller\EmployeeController::class, 'add'])->middleware('auth');
Route::add(['GET', 'POST'], '/employees/edit', [Controller\EmployeeController::class, 'edit'])->middleware('auth');
Route::add('GET', '/employees/delete', [Controller\EmployeeController::class, 'delete'])->middleware('auth');

// Кафедры
Route::add('GET', '/departments', [Controller\DepartmentController::class, 'index'])->middleware('auth');
Route::add(['GET', 'POST'], '/departments/add', [Controller\DepartmentController::class, 'add'])->middleware('auth');
Route::add(['GET', 'POST'], '/departments/edit', [Controller\DepartmentController::class, 'edit'])->middleware('auth');
Route::add('GET', '/departments/delete', [Controller\DepartmentController::class, 'delete'])->middleware('auth');

// Дисциплины
Route::add('GET', '/disciplines', [Controller\DisciplineController::class, 'index'])->middleware('auth');
Route::add(['GET', 'POST'], '/disciplines/add', [Controller\DisciplineController::class, 'add'])->middleware('auth');
Route::add(['GET', 'POST'], '/disciplines/edit', [Controller\DisciplineController::class, 'edit'])->middleware('auth');
Route::add('GET', '/disciplines/delete', [Controller\DisciplineController::class, 'delete'])->middleware('auth');
