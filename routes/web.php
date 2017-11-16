<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | This file is where you may define all of the routes that are handled
  | by your application. Just tell Laravel the URIs it should respond
  | to using a Closure or controller method. Build something great!
  |
 */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');



Route::group(['middleware' => ['auth', 'acl', 'admin.nav'], 'prefix' => 'admin'], function() {

//    Route::any('/role', ['as' => '.role.index', 'uses' => 'Admin\RoleController@index', 'can'=>'index.role']);
    Route::any('/', ['as' => 'admin', 'uses' => 'Admin\DashboardController@index']);

    //User Routes
    Route::group(['as' => 'admin.user', 'prefix' => 'user'], function () {
        Route::any('/index', ['as' => '.index', 'uses' => 'Admin\UserController@index']);
        Route::get('/view/{user}', ['as' => '.view', 'uses' => 'Admin\UserController@view']);
        Route::any('/create', ['as' => '.create', 'uses' => 'Admin\UserController@create']);
        Route::any('/data', ['as' => '.data', 'uses' => 'Admin\UserController@data']);
        Route::any('/update/{user}', ['as' => '.update', 'uses' => 'Admin\UserController@update']);
        Route::post('/delete/{user}', ['as' => '.delete', 'uses' => 'Admin\UserController@delete']);
    });

    // ACL Routes
    Route::group(['as' => 'admin.acl', 'prefix' => 'acl'], function () {
        Route::any('/role', ['as' => '.role.index', 'uses' => 'Admin\RoleController@index']);
        //Example to secure a route
        
        Route::get('/role/create', ['as' => '.role.create', 'uses' => 'Admin\RoleController@create']);
        Route::post('/role/create', ['as' => '.role.create', 'uses' => 'Admin\RoleController@store']);
        Route::get('/role/update/{role}', ['as' => '.role.edit', 'uses' => 'Admin\RoleController@edit']);
        Route::post('/role/update/{role}', ['as' => '.role.edit', 'uses' => 'Admin\RoleController@update']);
        Route::post('/role/delete/{role}', ['as' => '.role.delete', 'uses' => 'Admin\RoleController@destroy']);
        Route::get('/role/data', ['as' => '.role.data', 'uses' => 'Admin\RoleController@data']);
        Route::get('/role/permissions/{role}', ['as' => '.role.permissions', 'uses' => 'Admin\RoleController@permissions']);
        Route::post('/role/permissions/{role}', ['as' => '.role.permissions', 'uses' => 'Admin\RoleController@store_permissions']);
        
        Route::get('/permission', ['as' => '.permission.index', 'uses' => 'Admin\PermissionController@index']);
        Route::get('/permission/create', ['as' => '.permission.create', 'uses' => 'Admin\PermissionController@create']);
        Route::post('/permission/create', ['as' => '.permission.create', 'uses' => 'Admin\PermissionController@store']);
        Route::any('/permission/update/{permission}', ['as' => '.permission.edit', 'uses' => 'Admin\PermissionController@edit']);
        Route::post('/permission/update/{permission}', ['as' => '.permission.edit', 'uses' => 'Admin\PermissionController@update']);
        Route::post('/permission/delete/{permission}', ['as' => '.permission.delete', 'uses' => 'Admin\PermissionController@destroy']);
        Route::get('/permission/data', ['as' => '.permission.data', 'uses' => 'Admin\PermissionController@data']);
        Route::get('/permission/generate', ['as' => '.permission.generate', 'uses' => 'Admin\PermissionController@generate']);
        Route::post('/permission/generate', ['as' => '.permission.generate', 'uses' => 'Admin\PermissionController@store']);
        
    });
});
