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
Route::prefix('admin')
    ->namespace('Admin')
    ->middleware('auth')
    ->group(function(){
    
    /**
    * routes role x user
    */
    Route::get('users/{id}/role/{idRole}/detach', 'ACL\RoleUserController@detachRoleUser')->name('users.role.detach');
    Route::post('users/{id}/roles', 'ACL\RoleUserController@attachRolesUser')->name('users.roles.attach');
    Route::any('users/{id}/roles/create', 'ACL\RoleUserController@rolesAvailable')->name('users.roles.available');
    Route::get('users/{id}/roles', 'ACL\RoleUserController@roles')->name('users.roles');
    Route::get('roles/{id}/user', 'ACL\RoleUserController@users')->name('roles.users');

    /**
     * routes permission x roles
     */
    Route::get('roles/{id}/permission/{idPermission}/detach', 'ACL\PermissionRoleController@detachPermissionRole')->name('roles.permission.detach');
    Route::post('roles/{id}/permissions', 'ACL\PermissionRoleController@attachPermissionsRole')->name('roles.permissions.attach');
    Route::any('roles/{id}/permissions/create', 'ACL\PermissionRoleController@permissionsAvailable')->name('roles.permissions.available');
    Route::get('roles/{id}/permissions', 'ACL\PermissionRoleController@permissions')->name('roles.permissions');
    Route::get('permissions/{id}/role', 'ACL\PermissionRoleController@roles')->name('permissions.roles');

    /**
     * Routes Roles
     */
    Route::any('roles/search', 'ACL\RoleController@search')->name('roles.search');
    Route::resource('roles', 'ACL\RoleController');

    /**
     * routes product x category
     */
    Route::get('products/{id}/category/{idCategory}/detach', 'CategoryProductController@detachCategoryProduct')->name('products.category.detach');
    Route::post('products/{id}/categories', 'CategoryProductController@attachCategoriesProduct')->name('products.categories.attach');
    Route::any('products/{id}/categories/create', 'CategoryProductController@categoriesAvailable')->name('products.categories.available');
    Route::get('products/{id}/categories', 'CategoryProductController@categories')->name('products.categories');
    Route::get('categories/{id}/products', 'CategoryProductController@products')->name('categories.products');
    
    /**
    * Routes Users
    */
    Route::any('users/search', 'UserController@search')->name('users.search');
    Route::resource('users', 'UserController');

    /**
    * Routes Tenants
    */
    Route::any('tenants/search', 'TenantController@search')->name('tenants.search');
    Route::resource('tenants', 'TenantController');

    /**
    * Routes Products
    */
    Route::any('products/search', 'ProductController@search')->name('products.search');
    Route::resource('products', 'ProductController');

    /**
    * Routes Tables
    */
    Route::get('tables/qrcode/{identify}', 'TableController@qrcode')->name('tables.qrcode');
    Route::any('tables/search', 'TableController@search')->name('tables.search');
    Route::resource('tables', 'TableController');

    /**
    * Routes Categories
    */
    Route::any('categories/search', 'CategoryController@search')->name('categories.search');
    Route::resource('categories', 'CategoryController');

    /**
     * routes plan x profiles
     */
    Route::get('profiles/{id}/plan/{idPlan}/detach', 'ACL\PlanProfileController@detachPlanProfile')->name('plans.profiles.detach');
    Route::get('plans/{id}/profile/{idProfile}/detach', 'ACL\PlanProfileController@detachProfilePlan')->name('profiles.plans.detach');
    Route::post('profiles/{id}/plans', 'ACL\PlanProfileController@attachPlansProfile')->name('plans.profiles.attach');
    Route::post('plans/{id}/profiles', 'ACL\PlanProfileController@attachProfilesPlan')->name('profiles.plans.attach');
    Route::any('profiles/{id}/plans/create', 'ACL\PlanProfileController@plansAvailable')->name('plans.profiles.available');
    Route::any('plans/{id}/profiles/create', 'ACL\PlanProfileController@profilesAvailable')->name('profiles.plans.available');
    Route::get('profiles/{id}/plans', 'ACL\PlanProfileController@plans')->name('plans.profiles');
    Route::get('plans/{id}/profiles', 'ACL\PlanProfileController@profiles')->name('profiles.plans');

    /**
     * routes permission x profiles
     */
    Route::get('profiles/{id}/permission/{idPermission}/detach', 'ACL\PermissionProfileController@detachPermissionProfile')->name('profiles.permission.detach');
    Route::post('profiles/{id}/permissions', 'ACL\PermissionProfileController@attachPermissionsProfile')->name('profiles.permissions.attach');
    Route::any('profiles/{id}/permissions/create', 'ACL\PermissionProfileController@permissionsAvailable')->name('profiles.permissions.available');
    Route::get('profiles/{id}/permissions', 'ACL\PermissionProfileController@permissions')->name('profiles.permissions');
    Route::get('permissions/{id}/profile', 'ACL\PermissionProfileController@profiles')->name('permissions.profiles');
    
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
    Route::get('plans/details/{url}/create', 'DetailPlanController@create')->name('details.plan.create');
    Route::delete('plans/details/{url}/{idDetail}', 'DetailPlanController@delete')->name('details.plan.delete');
    Route::get('plans/details/{url}/{idDetail}', 'DetailPlanController@show')->name('details.plan.show');
    Route::put('plans/details/{url}/{idDetail}', 'DetailPlanController@update')->name('details.plan.update');
    Route::get('plans/details/edit/{url}/{idDetail}', 'DetailPlanController@edit')->name('details.plan.edit');
    Route::post('plans/details/{url}', 'DetailPlanController@store')->name('details.plan.store');
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
    Route::get('/', 'DashboardController@home')->name('admin.index');
});

/**
 * Site 
 */
Route::get('/plan/{url}', 'Site\SiteController@plan')->name('plan.subscription');
Route::get('/', 'Site\SiteController@index')->name('site.home');

/**
 * Auth routes
 */
Auth::routes();