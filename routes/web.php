<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Master\RoleController;
use App\Http\Controllers\Master\ConfigController;
use App\Http\Controllers\Master\UserController;

Route::get('/', function () {
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
    return redirect('login');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['namespace' => 'Master', 'prefix' => 'master'], function(){
    Route::group(['prefix' => 'roles'], function(){
        Route::get('/', [RoleController::class, 'index'])->name('master.role');
        Route::post('/', [RoleController::class, 'storeOrUpdate'])->name('master.role.storeOrUpdate');
        Route::delete('/{id}', [RoleController::class, 'delete'])->name('master.role.delete');
    });

    Route::group(['prefix' => 'config'], function() {
        Route::get('/', [ConfigController::class, 'index'])->name('master.config');
        Route::put('/', [ConfigController::class, 'update'])->name('master.config.update');
    });

    Route::group(['prefix' => 'users'], function() {
        Route::get('/', [UserController::class, 'index'])->name('master.users');
        Route::post('/', [UserController::class, 'storeOrUpdate'])->name('master.users.storeOrUpdate');
    });
});

require __DIR__.'/auth.php';
