<?php

// routes/api.php

use App\Http\Controllers\ApprenantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExcelExportController;
use App\Http\Controllers\ReferentielController;
use Illuminate\Support\Facades\Route;

Route::post('/v1/login', [AuthController::class, 'login']);

Route::get('/export-excel', [ExcelExportController::class, 'export'])->name('export.excel');

// Groupez toutes les routes sous un seul middleware
Route::middleware(['auth:api', 'success.response'])->prefix('/v1')->group(function () {
    
    // Routes pour les utilisateurs
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('/{id}', [UserController::class, 'show'])->name('users.show');
        Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/logout', [UserController::class, 'logout']);
    });

    // Routes pour les apprenants
    Route::prefix('apprenants')->group(function () {
        Route::post('/', [ApprenantController::class, 'store']);
        Route::post('/import', [ApprenantController::class, 'import']);
        Route::get('/', [ApprenantController::class, 'index']);
        Route::get('/{id}', [ApprenantController::class, 'show']);
        Route::get('/inactive', [ApprenantController::class, 'inactiveApprenants']);
        Route::post('/relance', [ApprenantController::class, 'sendBulkReminder']);
        Route::post('/{id}/relance', [ApprenantController::class, 'sendReminder']);
    });

    // Routes pour les promotions
    Route::prefix('promotions')->group(function () {
        Route::post('/', [PromotionController::class, 'create']);
        Route::patch('/{id}', [PromotionController::class, 'update']);
        Route::patch('/{id}/referentiels', [PromotionController::class, 'updateReferentiels']);
        Route::patch('/{id}/etat', [PromotionController::class, 'updateEtat']);
        Route::get('/', [PromotionController::class, 'index']);
        Route::get('/encours', [PromotionController::class, 'encours']);
        Route::patch('/{id}/cloturer', [PromotionController::class, 'cloturer']);
        Route::get('/{id}/referentiels', [PromotionController::class, 'getReferentiels']);
        Route::get('/{id}/stats', [PromotionController::class, 'getStats']);
    });

    // Routes pour les référentiels
    Route::prefix('referentiels')->group(function () {
        Route::get('/', [ReferentielController::class, 'index']);
        Route::post('/', [ReferentielController::class, 'store']);
        Route::get('/{id}', [ReferentielController::class, 'show']);
        Route::patch('/{id}', [ReferentielController::class, 'update']);
        Route::delete('/{id}', [ReferentielController::class, 'destroy']);
        Route::get('archive/referentiels', [ReferentielController::class, 'archived']);
    });
});
