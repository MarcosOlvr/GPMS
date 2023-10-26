<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();

Route::get('/', [ProjectController::class, 'index']);
Route::get('/edit/{project_id}', [ProjectController::class, 'edit']);
Route::get('/delete/{project_id}', [ProjectController::class, 'delete']);
Route::get('/list', [ProjectController::class, 'list']);
Route::get('/{project_id}', [ProjectController::class, 'show']);
Route::post('/store', [ProjectController::class, 'store']);
Route::put('/update/{project}', [ProjectController::class, "update"]);
Route::delete('/delete/{project}', [ProjectController::class, "destroy"]);