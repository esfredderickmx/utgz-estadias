<?php

use App\Http\Livewire\Areas\IndexAreas;
use App\Http\Livewire\Authentication\Login;
use App\Http\Livewire\Authentication\Password\Reset;
use App\Http\Livewire\Careers\IndexCareers;
use Illuminate\Support\Facades\Route;

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

Route::view('/', 'index')->name('index');

Route::view('/home', 'index')->name('home');

Route::get('/login', [Login::class, 'showForm'])->name('login')->middleware('guest');

Route::get('/reset-password', [Reset::class, 'showForm'])->name('password.reset-form')->middleware('guest');

Route::post('/reset-password')->name('password.reset')->middleware('guest');

Route::get('/areas', IndexAreas::class)->name('areas')->middleware(['auth', 'role:admin,manager']);

Route::get('/careers', IndexCareers::class)->name('careers')->middleware(['auth', 'role:admin,manager']);
