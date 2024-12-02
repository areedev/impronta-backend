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
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\AreaController;
use App\Http\Controllers\Api\CompetencyController;
use App\Http\Controllers\Api\CriteriaController;
use App\Http\Controllers\Api\UserController;

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
    Route::get('/evaluations/ver/{id}', [EvaluationController::class, 'show']);
    Route::get('/evaluations/practice/{id}', [EvaluationController::class, 'practice']);
    Route::get('/evaluations/comment/{id}', [EvaluationController::class, 'comment']);
    Route::post('/evaluations/comment/{id}', [EvaluationController::class, 'save_comment']);
    Route::post('/evaluations/notas/{id}', [EvaluationController::class, 'notas']);
    Route::get('/evaluations/validate', [EvaluationController::class, 'validar']);
    Route::get('/evaluations/theory/{id}', [EvaluationController::class, 'teorica']);
    Route::post('/evaluations/theory-update/{id}', [EvaluationController::class, 'teorica_update']);
    Route::post('/evaluations/theory-create/{id}', [EvaluationController::class, 'teorica_store']);
    Route::get('/evaluations/result/{id}', [EvaluationController::class, 'resultados']);
    Route::post('evaluations/status/{id}', [EvaluationController::class, 'actualizar_estado']);

    Route::get('/profiles', [ProfileEvaluationController::class, 'index']);
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

    Route::get('/user', [ProfileController::class, 'index']);
    Route::post('/user', [ProfileController::class, 'update']);
    Route::post('/user-password', [ProfileController::class, 'updatePassword']);

    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::resource('/tasks', TaskController::class);
    Route::resource('/areas', AreaController::class);
    Route::resource('/competencies', CompetencyController::class);
    Route::resource('/criterias', CriteriaController::class);
    Route::resource('/users', UserController::class);

});
Route::fallback(function(){
    return response()->json(['message' => 'Not found'], 404);
});