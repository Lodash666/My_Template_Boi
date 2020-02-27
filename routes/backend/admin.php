<?php

use App\Http\Controllers\Backend\DashboardController;

// All route names are prefixed with 'admin.'.
//Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::group(['prefix' => 'project', 'as' => 'project.', 'middleware' => 'project'], function () {
    Route::resource('/', 'ProjectController',[
        'names' => [
            'index' => 'index',
            'store'=>'store'
            // etc...
        ]
    ]);
});
Route::group(['prefix' => 'worker', 'as' => 'worker.', 'middleware' => 'worker'], function () {
    Route::resource('/', 'WorkerController',[
        'names' => [
            'index' =>'index',
            'store'=>'store'
            // etc...
        ]
    ]);
});

//--------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------


Route::group(['as'=>'menu.','middleware' => 'role:'.config('access.users.admin_role'),], function () {
    Route::resource('/menu', 'MenusController',[
        'names' => [
            'index' => 'index',
            'store'=>'store',
            'update'=>'update'
            // etc...
        ]
    ]);

});
Route::group(['as'=>'submenu.','middleware' => 'role:'.config('access.users.admin_role'),], function () {
    Route::get('/submenu/create/{menu_id?}','SubMenuController@create');
    Route::resource('/submenu', 'SubMenuController',[
        'names' => [
            'index' => 'index',
            'store'=>'store'
            // etc...
        ]
    ]);
});

