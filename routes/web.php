<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentController;


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
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
Route::get('/input', [ContentController::class, 'input'])->name('input');
Route::post('/save', [ContentController::class, 'save'])->name('save');
Route::get('/output', [ContentController::class, 'output'])->name('output');
Route::get('/detail/{content_id}', [ContentController::class, 'detail'])->name('detail');
Route::get('/edit/{content_id}', [ContentController::class, 'edit'])->name('edit');
Route::post('/update', [ContentController::class, 'update'])->name('update');
Route::post('/delete/{content_id}', [ContentController::class, 'delete'])->name('delete');
require __DIR__.'/auth.php';
