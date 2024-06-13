<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Login;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\TicketController;
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

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/', [TicketController::class, 'index']); // untuk memastikan bahwa ketika seseorang mengunjungi http://127.0.0.1:8000/



Route::resource('/ticket', TicketController::class); 

Route::resource('/dashboard', DashboardController::class);

// Route untuk login dan logout
Route::get('/login', [Login::class, 'showLoginForm'])->name('login');
Route::post('/login', [Login::class, 'login']);
Route::post('/logout', [Login::class, 'logout'])->name('logout');