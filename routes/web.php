<?php

use App\Http\Controllers\ToDoItemWebController;
use App\Http\Controllers\ToDoListWebController;
use App\Models\ToDoList;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

route::middleware('auth')->prefix('lists')->name('lists.')->group(function(){
    Route::get('/',             [ToDoListWebController::class, 'index'])->name('index');
    Route::get('/create',     function () {return view('todolists.create');})->name('create');
    Route::post('/create',      [ToDoListWebController::class, 'store'])->name('store');
    Route::get('/{toDoList}',    [ToDoListWebController::class, 'edit'])->name('edit');
    Route::put('/{toDoList}',   [ToDoListWebController::class, 'update'])->name('update');
    Route::delete('/{toDoList}', [ToDoListWebController::class, 'destroy'])->name('destroy');

    Route::prefix('{toDoList}/items')->name('items.')->group(function () {
        Route::get('/', [ToDoItemWebController::class, 'index'])->name('index');
        Route::get('/create',     function (ToDoList $toDoList) {return view('todolists.todoitems.create', compact('toDoList'));})->name('create');
        Route::post('/create', [ToDoItemWebController::class, 'store'])->name('store');
        Route::get('/{toDoItem}', [ToDoItemWebController::class, 'edit'])->name('edit');
        Route::put('/{toDoItem}', [ToDoItemWebController::class, 'update'])->name('update');
        Route::delete('/{toDoItem}', [ToDoItemWebController::class, 'destroy'])->name('destroy');
    });
});

Route::apiResource('todolists', ToDoListApiController::class)->except(['create'])->middleware('list.owner');

Route::get('/register', function () {return view('auth.register');})->name('register');
Route::post('/register', [UserController::class, 'registerWeb'])->name('register.submit');

Route::get('/login', function () {return view('auth.login');})->name('login');
Route::post('/login', [UserController::class, 'loginWeb'])->name('login.submit');
Route::post('/logout', [UserController::class, 'logoutWeb'])->name('logout');

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
