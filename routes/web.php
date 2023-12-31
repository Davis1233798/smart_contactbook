<?php

use App\Http\Controllers\ParentResponseController;
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

Route::redirect('/', '/admin');






Route::get('/response/{parentId}/{studentId}/', [ParentResponseController::class, 'showResponseForm'])->name('parent.response');
Route::post('/response/submit/{parentId}', [ParentResponseController::class, 'submitResponse'])->name('parent.response.submit');
