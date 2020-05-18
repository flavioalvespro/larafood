<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::prefix('admin')->namespace('Admin')->group(function(){
    
    /**
     * Routes Permissions
     */

    Route::any('permissions/search', 'ACL\PermissionController@search')->name('permissions.search');
    Route::resource('permissions', 'ACL\PermissionController');

    /**
     * Routes Profiles
     */

    Route::any('profiles/search', 'ACL\ProfileController@search')->name('profiles.search');
    Route::resource('profiles', 'ACL\ProfileController');
    
    /**
     * routes details plan
     */
    Route::delete('plans/details/{url}/{idDetail}', 'DetailPlanController@delete')->name('details.plan.delete');
    Route::get('plans/details/{url}/{idDetail}', 'DetailPlanController@show')->name('details.plan.show');
    Route::put('plans/details/{url}/{idDetail}', 'DetailPlanController@update')->name('details.plan.update');
    Route::get('plans/details/edit/{url}/{idDetail}', 'DetailPlanController@edit')->name('details.plan.edit');
    Route::post('plans/details/{url}', 'DetailPlanController@store')->name('details.plan.store');
    Route::get('plans/details/{url}/create', 'DetailPlanController@create')->name('details.plan.create');
    Route::get('plans/details/{url}', 'DetailPlanController@index')->name('details.plan.index');

    /**
     * routes plans
     */
    Route::post('plans', 'PlanController@store')->name('plans.store');
    Route::get('plans', 'PlanController@index')->name('plans.index');
    Route::get('plans/create', 'PlanController@create')->name('plans.create');
    Route::any('plans/search', 'PlanController@search')->name('plans.search');
    Route::get('plans/{url}', 'PlanController@show')->name('plans.show');
    Route::get('plans/edit/{url}', 'PlanController@edit')->name('plans.edit');
    Route::delete('plans/{url}', 'PlanController@destroy')->name('plans.destroy');
    Route::put('plans/{url}', 'PlanController@update')->name('plans.update');

    /**
     * route dash
     */
    Route::get('/', 'PlanController@index')->name('admin.index');
});

Route::get('/', function () {
    return view('welcome');
});
