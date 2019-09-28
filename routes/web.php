<?php

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

Route::get('/', [
    'uses' => 'UserController@index',
    'as' => 'login'
]);
Route::post('/', [
    'uses' => 'UserController@login',
    'as' => 'LoginPost'
]);
Route::post('/reg', [
    'uses' => 'UserController@register',
    'as' => 'Reg'
]);


//logged in
Route::group([
	
	'middleware'	=> ['auth']]

	,function(){
        Route::get('/get-current-user', [
            'uses' => 'StatusController@getCurrentUser',
            'as' => 'curentuser'
        ]);

        Route::get('/logout', [
            'uses'	=> 'UserController@logout',
            'as'	=> 'logout'
        ]);

        Route::get('/status', [
            'uses' => 'StatusController@index',
            'as' => 'status'
        ]);

        Route::post('/status', [
            'uses' => 'StatusController@post',
            'as' => 'statuspost'
        ]);

        Route::get('/data-status', [
            'uses' => 'StatusController@datas',
            'as' => 'statusdatas'
        ]);

        Route::post('/update-profile', [
            'uses' => 'StatusController@updateProfile',
            'as' => 'profileudpate'
        ]);

        Route::post('/uploadImage',[
            'uses' => 'StatusController@uploadImage',
            'as'   => 'uploadImage'
        ]);



});







// Route::get('/home', 'HomeController@index')->name('home');
