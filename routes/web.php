<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\generalController;
use App\Http\Controllers\ipss;
use App\Http\Controllers\emailInsertController;
use App\Http\Controllers\modalInputFileController;
use App\Models\Isp;

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/allData',[generalController::class,'index']);

Route::post('/insert',[emailInsertController::class, 'insert']);
Route::post('/insertGeo',[emailInsertController::class, 'insertGeo']);
Route::post('/insertIsp',[emailInsertController::class, 'insertIsp']);


Route::post('/testFunction',[modalInputFileController::class, 'testFunction']);
Route::post('/getFile',[modalInputFileController::class,'getFile']);
Route::post('/domainName',[modalInputFileController::class,'domainName']);