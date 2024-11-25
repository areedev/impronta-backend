<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\CandidateController;
use App\Http\Controllers\Api\EvaluationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CompanyController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/candidates', [CandidateController::class, 'index']);
    Route::get('/candidate/{id}', [CandidateController::class, 'show']);
    Route::get('/evaluations', [EvaluationController::class, 'index']);
    Route::get('/profiles', [ProfileController::class, 'index']);
    Route::get('/companies', [CompanyController::class, 'index']);
});
Route::fallback(function(){
    return response()->json(['message' => 'Not found'], 404);
});