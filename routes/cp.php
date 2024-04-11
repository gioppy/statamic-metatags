<?php

Route::view('metatags', 'statamic-metatags::index')->name('metatags.index');

Route::get('metatags/settings', [\Gioppy\StatamicMetatags\Services\Http\Controllers\SettingsController::class, 'edit'])->name('metatags.settings');
Route::post('metatags/settings', [\Gioppy\StatamicMetatags\Services\Http\Controllers\SettingsController::class, 'update'])->name('metatags.settings.update');

Route::get('metatags/defaults', [\Gioppy\StatamicMetatags\Services\Http\Controllers\DefaultsController::class, 'edit'])->name('metatags.defaults');
Route::post('metatags/defaults', [\Gioppy\StatamicMetatags\Services\Http\Controllers\DefaultsController::class, 'update'])->name('metatags.defaults.update');
