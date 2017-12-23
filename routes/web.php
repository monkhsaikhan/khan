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

Route::get('/', 'WelcomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/exam/{id}', 'HomeController@exam')->name('exam');
Route::patch('/exam/{id}/sendResult', 'HomeController@sendResult')->name('exam.sendResult');
Route::get('/exam/histories', 'HomeController@histories')->name('exam.histories');
Route::get('/exam/{id}/history', 'HomeController@history')->name('exam.history');

Route::get('/test/create', 'TestController@create')->name('test.create');

Route::get('/test/{id}/questions', 'QuestionController@index')->name('test.questions.index');

Route::group(['prefix' => 'api'], function() {
    Route::get('tests', 'TestController@index')->name('test.index');
    Route::get('test/{id}', 'TestController@show')->name('test.show');
    Route::post('test/store', 'TestController@store')->name('test.store');
    Route::delete('tests/{id}/destroy', 'TestController@destroy')->name('test.destroy');

    Route::post('test/{id}/questions/store', 'QuestionController@store')->name('test.questions.store');
    Route::delete('questions/{id}/destroy', 'QuestionController@destroy')->name('test.questions.destroy');
});