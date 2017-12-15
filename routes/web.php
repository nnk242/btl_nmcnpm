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
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', function () {
    return redirect('/login');
});

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/user/edit', 'HomeController@edit')->name('user.edit');
Route::post('/user/editIMG', 'HomeController@ajaxEditImg')->name('ajax.editImg');


Route::get('/result', 'ResultController@index')->name('result');
Route::get('/result/store', 'ResultController@store')->name('result.store');
Route::get('/result/show/{id}', 'ResultController@show')->name('result.show');
Route::get('/result/search', 'ResultController@search');

Route::get('/input-point', 'InputPointController@index')->name('input.point')->middleware('teacher');
Route::post('/input-point/ajax-ky', 'InputPointController@ajaxKy')->name('ajax.ky');
Route::post('/input-point/edit', 'InputPointController@edit')->name('point.edit')->middleware('teacher');

//

Route::get('/add-user', 'AddUserController@index')->middleware('manager');
Route::post('/add-user/create-user', 'AddUserController@create')->name('create.user')->middleware('manager');
Route::post('/add-user/create-student', 'AddUserController@studentCreate')->name('create.student')->middleware('manager');

Route::post('/add-user/delete/{id}', 'AddUserController@destroy')->name('delete.username')->middleware('manager');


//change password
Route::post('changePassword', 'ChangePassword@postCredentials')->name('changePassword');

//excel
Route::get('excel', 'ExcelController@index');
Route::post('excel/post', 'ExcelController@post')->name('excel.post');