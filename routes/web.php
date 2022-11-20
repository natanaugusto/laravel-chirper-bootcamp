<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProfileController;
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

Route::get(uri:'/', action:function () {
    return Inertia::render(component:'Welcome', props:[
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get(uri:'/dashboard', action:function () {
    return Inertia::render(component:'Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(callback:function () {
    Route::get(uri:'/profile', action:[ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch(uri:'/profile', action:[ProfileController::class, 'update'])->name('profile.update');
    Route::delete(uri:'/profile', action:[ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource(name:'chirps', controller:ChirpController::class)
    ->only(methods:['index', 'store', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
