<?php

use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;

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

//Route::get('/pdf', [PDFController::class, 'request_case']);
//Route::get('/list-companies-excel', [CompanyController::class, 'excel_list']);
Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');
