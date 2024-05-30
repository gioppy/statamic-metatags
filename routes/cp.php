<?php

use Gioppy\StatamicMetatags\Http\Controllers\BlueprintsController;
use Gioppy\StatamicMetatags\Http\Controllers\DefaultsController;
use Gioppy\StatamicMetatags\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::prefix('metatags')->group(function () {
    Route::view('/', 'statamic-metatags::index')->name('metatags.index');

    Route::get('/settings', [SettingsController::class, 'edit'])->name('metatags.settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('metatags.settings.update');

    Route::get('/defaults', [DefaultsController::class, 'edit'])->name('metatags.defaults');
    Route::post('/defaults', [DefaultsController::class, 'update'])->name('metatags.defaults.update');

    Route::prefix('blueprints')->group(function () {
        Route::get('/', [BlueprintsController::class, 'index'])->name('metatags.blueprints');

        Route::prefix('/{type}/{entity}/{name}')->group(function () {
            Route::get('/settings', [BlueprintsController::class, 'editSettings'])->name('metatags.blueprints.editSettings');
            Route::post('/settings', [BlueprintsController::class, 'updateSettings'])->name('metatags.blueprints.updateSettings');
            Route::get('/defaults', [BlueprintsController::class, 'editDefaults'])->name('metatags.blueprints.editDefaults');
            Route::post('/defaults', [BlueprintsController::class, 'updateDefaults'])->name('metatags.blueprints.updateDefaults');
        });
    });
});
