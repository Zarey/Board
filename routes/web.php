<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\MyadvController;
use App\Http\Controllers\ModerateController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CategoryController;

use Illuminate\Support\Facades\Artisan;

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

Route::get('clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
	Artisan::call('route:clear');
    return "Кэш очищен ".date( "d.m.Y H:i:s" );
});

Route::get('logout', function () {
	Auth::logout();
	return redirect('/');
});

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');


// Доска объявлений
Route::get('/', [BoardController::class, 'index']);
Route::get('adv/{id}', [BoardController::class, 'adv']);
Route::get('cat/{id}', [BoardController::class, 'cat']);
Route::get('user/{id}', [BoardController::class, 'user']);

// Управление публичными контактными данными
Route::resource('card', CardController::class)
	->parameters(['card' => 'id'])
	->only(['edit', 'update'])
	->middleware('author_or_admin');

// Управление своими объявлениями
Route::resource('myadv', MyadvController::class)->middleware('is_my_adv');
Route::post('myadv/{myadv}/up', [MyadvController::class, 'up'])->name('myadv.up')->middleware('is_my_adv');
Route::post('myadv/{myadv}/on', [MyadvController::class, 'on'])->name('myadv.on')->middleware('is_my_adv');
Route::post('myadv/{myadv}/off', [MyadvController::class, 'off'])->name('myadv.off')->middleware('is_my_adv');

// Модерация
Route::get('moderate/', [ModerateController::class, 'index'])->middleware('is_admin');
Route::get('moderate/approved', [ModerateController::class, 'approved'])->middleware('is_admin');
Route::get('moderate/rejected', [ModerateController::class, 'rejected'])->middleware('is_admin');
Route::get('moderate/{id}', [ModerateController::class, 'moderate'])->name('moderate')->middleware('is_admin');
Route::post('moderate/{id}/approve', [ModerateController::class, 'approve'])->name('moderate.approve')->middleware('is_admin');
Route::post('moderate/{id}/reject', [ModerateController::class, 'reject'])->name('moderate.reject')->middleware('is_admin');

Route::get('moderate/{id}/editable', [ModerateController::class, 'editable'])->name('moderate.editable')->middleware('is_admin');
Route::post('moderate/{id}/change', [ModerateController::class, 'change'])->name('moderate.change')->middleware('is_admin');
Route::post('moderate/{id}/upadv', [ModerateController::class, 'upadv'])->name('moderate.upadv')->middleware('is_admin');
Route::post('moderate/{id}/onadv', [ModerateController::class, 'onadv'])->name('moderate.onadv')->middleware('is_admin');
Route::post('moderate/{id}/offadv', [ModerateController::class, 'offadv'])->name('moderate.offadv')->middleware('is_admin');
Route::post('/moderate/{id}/destroy', [ModerateController::class, 'destroy'])->name('moderate.destroy')->middleware('is_admin');


// Категории
Route::get('category/', [CategoryController::class, 'index'])->middleware('is_admin');
Route::post('category/create', [CategoryController::class, 'create'])->middleware('is_admin');
Route::post('category/{id}/update', [CategoryController::class, 'update'])->name('category.update')->middleware('is_admin');
Route::post('category/{id}/destroy', [CategoryController::class, 'destroy'])->name('category.destroy')->middleware('is_admin');
Route::post('category/{id}/on', [CategoryController::class, 'on'])->name('category.on')->middleware('is_admin');
Route::post('category/{id}/off', [CategoryController::class, 'off'])->name('category.off')->middleware('is_admin');