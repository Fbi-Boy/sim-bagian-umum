<?php

use App\Http\Controllers\Modules\Organization\OrganizationalUnitController;
use Illuminate\Support\Facades\Route;

Route::prefix('organization')
    ->name('organization.')
    ->middleware(['auth'])
    ->group(function () {
        Route::resource('units', OrganizationalUnitController::class)->only(['index', 'create', 'store']);
    });