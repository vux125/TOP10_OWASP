<?php

use App\Http\Controllers\FileUploadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InjectionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TraversalController;
use App\Http\Controllers\SSRFController;

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

Route::get('/', [HomeController::class, 'index']);

Route::prefix('injection')->group(function () {
    Route::get('', [InjectionController::class, 'index']);
    Route::get('os', [InjectionController::class, 'viewOsInjection']);
    Route::post('os', [InjectionController::class, 'osInjection']);
    Route::prefix('sql')->group(function () {
        Route::get('in-band', [InjectionController::class, 'viewSqlInjectionInBand']);
        Route::get('in-band/detail', [InjectionController::class, 'sqlInjectionInBand']);
        Route::post('inferential/like', [InjectionController::class, 'likePost']);
        Route::get('inferential_boolean', [InjectionController::class, 'viewSqlInjectionInferentialBoolean']);
    });
    Route::prefix('xss')->group(function () {
        Route::get('reflected', [InjectionController::class, 'xssInjectionReflected']);
        Route::post('reflected', [InjectionController::class, 'xssInjectionReflected']);
        Route::get('stored', [InjectionController::class, 'xssInjectionStored']);
        Route::post('stored/comment', [InjectionController::class, 'handleComment']);
    });
});

Route::get('fileUpload', [FileUploadController::class, 'viewFileUpload']);
Route::post('fileUpload', [FileUploadController::class, 'fileUpload']);


Route::get('traversal', [TraversalController::class, 'viewTraversal']);

Route::get('ssrf', [SSRFController::class, 'index']);
