<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});

Route::get('api/companytype/{id}', ['uses' => 'ApiController@companytype']);
Route::get('api/usercompanies/{id}', ['uses' => 'ApiController@usercompanies']);
Route::get('api/usercompanydetails/{id}', ['uses' => 'ApiController@usercompanydetails']);
Route::post('api/retrievesavedcompany', ['uses' => 'ApiController@retrievesavedcompany']);
Route::post('api/uploadfiles', ['uses' => 'ApiController@uploadfiles']);
Route::get('admin', ['uses' => 'AdminController@index']);
Route::group(['middleware' => 'web'], function() {
	Route::resource('admin/jurisdiction', 'JurisdictionController');	
});
Route::resource('admin/company', 'CompanyController');
