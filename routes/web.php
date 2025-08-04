<?php

use App\Http\Controllers\DomainController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RepoStatusController;
use Illuminate\Support\Facades\Route;


//_______________________________AUTH_________________________________________//
Route::get('/login',[LoginController::class,'create'])->name('login');
Route::Post('login',[LoginController::class,'store']);
Route::post('logout',[LoginController::class,'destroy']);
//_______________________________AUTH_________________________________________//


//_______________________________DOMAINS_________________________________________//
Route::controller(DomainController::class)->group(function () {
Route::get('/domains','index')->middleware('auth');
Route::get('/','indexAll')->middleware('auth');
Route::get('/create','create')->name('domain.create')->middleware('auth');
Route::post('/create','store')->name('domain.store')->middleware('auth');
Route::get('/domains/edit/{domain}', 'edit')->name('domain.edit')->middleware('auth');
Route::patch('/domains/edit/{domain}',  'update')->name('domain.update')->middleware('auth');
Route::delete('/domains/{domain}','destroy')->name('domain.destroy')->middleware('auth');
});
//_______________________________DOMAINS_________________________________________//



//_______________________________DOMAINS_________________________________________//



Route::get('/repo/input', [RepoStatusController::class, 'showInputForm'])->name('repo.input')->middleware('auth');
Route::get('/repo/input', [RepoStatusController::class, 'showInputForm'])->name('repo.input')->middleware('auth');
Route::post('/repo-status', [RepoStatusController::class, 'checkRepoStatus'])->name('repo.status')->middleware('auth');
Route::post('/download-file', [RepoStatusController::class, 'downloadChangedFile'])->name('downloadChangedFile')->middleware('auth');
Route::post('/download-all', [RepoStatusController::class, 'downloadAllFiles'])->name('downloadAllFiles')->middleware('auth');
Route::post('/download-file', [RepoStatusController::class, 'downloadChangedFile'])->name('downloadChangedFile');
Route::post('/download-files-zip', [RepoStatusController::class, 'downloadFilesAsZip'])->name('downloadFilesZip')->middleware('auth');
//_______________________________DOMAINS_________________________________________//



