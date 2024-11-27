<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\CandidateController;
use App\Http\Controllers\Api\EvaluationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ProfileEvaluationController;
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
    Route::post('/candidate', [CandidateController::class, 'create']);
    Route::delete('/candidate/{id}', [CandidateController::class, 'destroy']);
    Route::get('/evaluations', [EvaluationController::class, 'index']);
    Route::post('/evaluations', [EvaluationController::class, 'store']);
    Route::get('/evaluations/practice/{id}', [EvaluationController::class, 'practice']);
    Route::get('/evaluations/validate', [EvaluationController::class, 'validar']);
    Route::get('/profiles', [ProfileController::class, 'index']);
    Route::post('/profile', [ProfileEvaluationController::class, 'store']);
    Route::post('/profile/update/{id}', [ProfileEvaluationController::class, 'update']);
    Route::post('/profile/new-section', [ProfileEvaluationController::class, 'nueva_seccion']);
    Route::post('/profile/new-column', [ProfileEvaluationController::class, 'nueva_columna']);
    Route::post('/profile/competencies', [ProfileEvaluationController::class, 'competencies']);
    Route::delete('/profile/{id}', [ProfileEvaluationController::class, 'destroy']);
    Route::get('/profile/edit/{id}', [ProfileEvaluationController::class, 'edit']);
    Route::get('/companies', [CompanyController::class, 'index']);
    Route::get('/company/{id}', [CompanyController::class, 'edit']);
    Route::post('/company/{id}', [CompanyController::class, 'store']);
    Route::delete('/company/{id}', [CompanyController::class, 'destroy']);
});
Route::fallback(function(){
    return response()->json(['message' => 'Not found'], 404);
});