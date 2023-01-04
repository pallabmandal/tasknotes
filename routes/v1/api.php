<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\Auth\AuthController;
use App\Http\Controllers\v1\Task\TaskController;
use App\Http\Controllers\v1\Task\TaskNoteController;

Route::group(['namespace' => 'v1'], function () {
	Route::prefix('auth')->group(function () {
	   Route::post('login', [AuthController::class, 'login']);
	   Route::post('signup', [AuthController::class, 'signup']);
	});

	Route::middleware(['auth:api'])->group(function () {
		Route::prefix('task')->group(function () {
			Route::post('get', [TaskController::class, 'get']);
			Route::post('show', [TaskController::class, 'show']);
			Route::post('create', [TaskController::class, 'create']);
			Route::post('update-task', [TaskController::class, 'update']);
			
			Route::prefix('note')->group(function () {
				Route::post('add-note', [TaskNoteController::class, 'create']);
				Route::post('delete-note', [TaskNoteController::class, 'delete']);
			});
		});
	});
});