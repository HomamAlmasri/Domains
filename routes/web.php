<?php

use App\Http\Controllers\DomainController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;


//_______________________________AUTH_________________________________________//
Route::get('/login',[LoginController::class,'create'])->name('login');
Route::Post('login',[LoginController::class,'store']);
Route::post('logout',[LoginController::class,'destroy']);
//_______________________________AUTH_________________________________________//



//_______________________________DOMAINS_________________________________________//
Route::controller(DomainController::class)->group(function () {
Route::get('/','index');
Route::get('/domains','indexAll')->middleware('auth');
Route::get('/create','create')->name('domain.create')->middleware('auth');
Route::post('/create','store')->name('domain.store')->middleware('auth');
Route::get('/domains/edit/{domain}', 'edit')->name('domain.edit')->middleware('auth');
Route::patch('/domains/edit/{domain}',  'update')->name('domain.update')->middleware('auth');
Route::delete('/domains/{domain}','destroy')->name('domain.destroy')->middleware('auth');
});
//_______________________________DOMAINS_________________________________________//



