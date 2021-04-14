<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResources([
    'user' => 'API\UserController',
    'post' => 'API\PostController',
    'category' => 'API\CategoryController',
    'fontend' => 'API\FontendController'
]);


Route::get('profile', 'API\UserController@profile');
Route::get('findUser', 'API\UserController@search');
Route::put('profile', 'API\UserController@updateProfile');

Route::post('isPublished/{id}', 'API\CategoryController@updateIsPublished');
Route::get('findCategory', 'API\CategoryController@search');
Route::post('isPost/{id}', 'API\PostController@updateIsPublished');
Route::get('findPost', 'API\PostController@search');
Route::get('postUser/{id}', 'API\PostController@postUser');