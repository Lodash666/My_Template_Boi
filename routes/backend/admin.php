<?php

use App\Http\Controllers\Backend\DashboardController;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::group(['prefix' => 'project', 'as' => 'project.', 'middleware' => 'project'], function () {
    Route::get('/', 'ProjectController@index')->name('index');

});
