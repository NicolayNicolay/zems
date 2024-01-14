<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Auth\Controllers\AuthController;
use Modules\Auth\Controllers\RegisterController;
use Modules\Projects\Controllers\ProjectsController;
use Modules\Statistics\Controllers\StatisticController;
use Modules\Tasks\Controllers\TasksController;

Route::group(['prefix' => 'api'], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/checkAuth', [AuthController::class, 'getCurrentAuth'])->name('auth.currentAuth');
    // Административная часть сайта
    Route::group(['prefix' => 'admin'], function () {
        Route::post('/register', [RegisterController::class, 'store'])
            ->name('admin.register.submit');
        Route::group(['middleware' => ['auth']], function () {
            Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
            //Проекты
            Route::group(
                ['prefix' => 'projects'],
                static function () {
                    Route::post('/projectsList', [ProjectsController::class, 'index'])->name('projects.projectsList');
                    Route::get('/get_form/{id?}', [ProjectsController::class, 'getFormParams'])->name('projects.get_form');
                    Route::get('/get_tasks/{id?}', [ProjectsController::class, 'getTasks'])->name('projects.getTasks');
                    Route::get('/remove/{id?}', [ProjectsController::class, 'destroy'])->name('projects.remove');
                    Route::post('/store', [ProjectsController::class, 'store'])->name('projects.store');
                }
            );
            //Задачи
            Route::group(
                ['prefix' => 'tasks'],
                static function () {
                    Route::post('/store', [TasksController::class, 'store'])->name('tasks.store');
                    Route::post('/changeState', [TasksController::class, 'changeState'])->name('tasks.changeState');
                    Route::post('/startTask', [TasksController::class, 'startTask'])->name('tasks.startTask');
                    Route::post('/endTask', [TasksController::class, 'endTask'])->name('tasks.endTask');
                }
            );
            //Статистика
            Route::group(
                ['prefix' => 'statistics'],
                static function () {
                    Route::get('/getData', [StatisticController::class, 'index'])->name('statistics.getData');
                }
            );
        });
    });
})->middleware('auth');

Route::get('/{any}', fn() => view('spa'))
    ->where('any', '.*')
    ->name('spa');
