<?php

use Illuminate\Support\Facades\Route;
use Shipu\WebInstaller\Livewire\Installer;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('installer', Installer::class)->name('installer')
//     ->middleware(['web']);

// Route::get('/', function () {
//     return view('web-installer::success');
// })->name('installer.success')->middleware(['web', 'redirect.if.not.installed']);
