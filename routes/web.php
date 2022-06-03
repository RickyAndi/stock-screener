<?php

use App\Http\Controllers\DetailController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\IndexController;
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

Route::get('/', [IndexController::class, 'index']);
Route::get('/filter', [FilterController::class, 'filter']);
Route::get('/detail/{ticker}', [DetailController::class, 'showDetail'])
    ->name('ticker.detail');
