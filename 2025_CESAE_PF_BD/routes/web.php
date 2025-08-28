<?php

use App\Http\Controllers\homeController;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return view('welcome');
});

Route::get('/home', [homeController::class, 'index'])->name('casa');

Route::get('/dashboard',[dashboardController::class,'general'])->name('dashboard_view'); // Rota que mostra a página dashboard
