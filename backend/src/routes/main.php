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
