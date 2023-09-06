<?php

use App\Http\Controllers\Api\Asuransi\AsuransiMobilApiController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\MasterController;
use App\Http\Controllers\Api\Auth\UserRegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);

Route::get('selectAgent', [MasterController::class, 'selectAgent']);
Route::get('selectAsuransiMobil', [MasterController::class, 'selectAsuransiMobil']);

Route::get('selectMerkMobil/{merk}', [MasterController::class, 'selectMerkMobil']);
Route::get('selectTahunMobil/{seri_id}', [MasterController::class, 'selectTahunMobil']);
Route::get('selectTipeMobil', [MasterController::class, 'selectTipeMobil']);
Route::get('selectSeriMobil/{merk_id}', [MasterController::class, 'selectSeriMobil']);
Route::get('selectTipeKendaraan', [MasterController::class, 'selectTipeKendaraan']);

Route::get('selectTipePemakaian', [MasterController::class, 'selectTipePemakaian']);
Route::get('selectLuasPertanggungan', [MasterController::class, 'selectLuasPertanggungan']);
Route::get('selectKondisiKendaraan', [MasterController::class, 'selectKondisiKendaraan']);
Route::get('selectKodePlat', [MasterController::class, 'selectKodePlat']);

Route::get('selectProvince', [MasterController::class, 'selectProvince']);
Route::get('selectCity/{id}', [MasterController::class, 'selectCity']);
Route::get('selectDistrict/{id}', [MasterController::class, 'selectDistrict']);
Route::get('selectVillage/{id}', [MasterController::class, 'selectVillage']);

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('users', UserRegisterController::class);
});

Route::post('agentAsuransiMobil', [AsuransiMobilApiController::class, 'agentAsuransiMobil']);
Route::post('agentPenawaranAsuransiMobil', [AsuransiMobilApiController::class, 'agentPenawaranAsuransiMobil']);
Route::post('testFiles', [AsuransiMobilApiController::class, 'testFiles']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// foreach (\File::allFiles(__DIR__ . '/api') as $file) {
//     require $file->getPathname();
// }
