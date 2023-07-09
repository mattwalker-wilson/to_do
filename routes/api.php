<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ToDoListController;
use App\Http\Controllers\ToDoItemsController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
        $phpVersion = phpversion();
        return response()->json([
            'message' => 'Welcome to the To Do List API! The PHP version is: ' . $phpVersion,
            'status' => 'Connected'
        ]);
});

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::middleware('jwt.verify')->group(function () {
    Route::post('logout', [UserController::class, 'logout']);
    Route::apiResource('user', UserController::class)->middleware('loggedin.user');
    Route::apiResource('todolists', ToDoListController::class)->except(['create'])->middleware('list.owner');
    Route::post('todolists',  [ToDoListController::class, 'store']);
    Route::apiResource('todolists.todoitems', ToDoItemsController::class);       
});
