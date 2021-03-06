<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// List Articles
Route::get('/articles', 'ArticleController@index')->name('article.index');

// List Single Article
Route::get('/article/{id}', 'ArticleController@edit')->name('article.edit');

// Create new Article
Route::post('/article', 'ArticleController@store')->name('article.store');

// Update Article
Route::put('/article', 'ArticleController@store')->name('article.update');

// Delete Article
Route::delete('/article/{id}', 'ArticleController@destroy')->name('article.destroy');
