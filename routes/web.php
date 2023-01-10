<?php

use App\Http\Controllers\MetallController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [MetallController::class, 'home'])->name('home');

Route::post('/add-categorie/', [MetallController::class, 'addCategorie'])->name('addCategorie');
Route::post('accept-metall', [MetallController::class, 'acceptMetal'])->name('acceptMetall');
Route::post('ship-metall', [MetallController::class, 'shipMetall'])->name('shipMetall');

Route::match(['get', 'post'],'stat-metall', [MetallController::class, 'createStatMetall'])->name('createStatMetall');
Route::post('stat-metall', [MetallController::class, 'storeStatMetall'])->name('storeStatMetall');

Route::match(['get', 'post'], 'stat-metall/categories', [MetallController::class, 'createStatMetallCategories'])->name('createStatMetallCategories');
