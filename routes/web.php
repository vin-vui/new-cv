<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\FrontController;

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

Route::get('/', [FrontController::class, 'index'])->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Back/Dashboard');
    })->name('dashboard');

    Route::resource('skills', SkillController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('formations', FormationController::class);
    Route::resource('about', AboutController::class);
    Route::resource('links', LinkController::class);
});
