<?php

use App\Http\Route;
use App\Middleware\AuthMiddleware;

// Usuários
Route::post('/users', 'UserController@store');
Route::post('/users/login', 'UserController@login');
Route::get('/users/me', 'UserController@fetch', [AuthMiddleware::class]);

// Alunos
Route::get('/students', 'StudentController@index', [AuthMiddleware::class]);
Route::get('/students/{id}', 'StudentController@fetch', [AuthMiddleware::class]);
Route::post('/students', 'StudentController@store', [AuthMiddleware::class]);
Route::put('/students/{id}', 'StudentController@update', [AuthMiddleware::class]);
Route::delete('/students/{id}', 'StudentController@delete', [AuthMiddleware::class]);
Route::patch('/students/{id}/assign-class', 'StudentController@assignToClass', [AuthMiddleware::class]);

// Turmas
Route::get('/classes', 'FiapClassController@index', [AuthMiddleware::class]);
Route::get('/classes/{id}', 'FiapClassController@fetch', [AuthMiddleware::class]);
Route::post('/classes', 'FiapClassController@store', [AuthMiddleware::class]);
Route::put('/classes/{id}', 'FiapClassController@update', [AuthMiddleware::class]);
Route::delete('/classes/{id}', 'FiapClassController@delete', [AuthMiddleware::class]);
