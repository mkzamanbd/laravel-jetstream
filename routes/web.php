<?php

use App\Http\Controllers\PHPSpreadsheetController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


Route::get('upload-excel', [PHPSpreadsheetController::class, 'index'])
    ->middleware(['auth'])
    ->name('upload-excel');

Route::post('upload-excel', [PHPSpreadsheetController::class, 'preview'])
    ->middleware(['auth'])
    ->name('upload-excel');

Route::post('upload-confirm', [PHPSpreadsheetController::class, 'store'])
    ->middleware(['auth'])
    ->name('upload-confirm');

Route::get('export-excel', [PHPSpreadsheetController::class, 'show'])
    ->middleware(['auth'])
    ->name('export-excel');

Route::post('export-excel', [PHPSpreadsheetController::class, 'export'])
    ->middleware(['auth'])
    ->name('download-excel');
