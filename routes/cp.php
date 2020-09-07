<?php

Route::view('metatags', 'statamic-metatags::index')->name('metatags.index');

Route::get('metatags/settings', 'SettingsController@edit')->name('metatags.settings');
Route::post('metatags/settings', 'SettingsController@update')->name('metatags.settings.update');

Route::get('metatags/defaults', 'DefaultsController@edit')->name('metatags.defaults');
Route::post('metatags/defaults', 'DefaultsController@update')->name('metatags.defaults.update');
