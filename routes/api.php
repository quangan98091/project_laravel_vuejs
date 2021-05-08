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
    'fontend' => 'API\FontendController',
]);


Route::get('profile', 'API\UserController@profile');
Route::get('findUser', 'API\UserController@search');
Route::put('profile', 'API\UserController@updateProfile');

Route::post('isPublished/{id}', 'API\CategoryController@updateIsPublished');
Route::get('findCategory', 'API\CategoryController@search');
Route::post('isPost/{id}', 'API\PostController@updateIsPublished');
Route::get('findPost', 'API\PostController@search');
Route::get('postUser/{id}', 'API\PostController@postUser');


Route::post('chat/newRoom/{id}', 'ChatController@newRoom');
Route::get('chat/room/{roomId}', 'ChatController@room');
Route::get('chat/roomAll', 'ChatController@roomAll');
Route::get('chat/room/{roomId}/messages', 'ChatController@messages');
Route::post('chat/room/{roomId}/message', 'ChatController@newMessage');

Route::get('getCategory', 'API\FontendController@category');
Route::get('getCategoryRandom', 'API\FontendController@categoryRandom');
Route::get('getCategoryAll', 'API\FontendController@categoryAll');
Route::get('getCategoryPost/{id}', 'API\FontendController@categoryPost');
Route::get('mostLikedPost', 'API\FontendController@mostLikedPost');
Route::get('mostViewedPost', 'API\FontendController@mostViewedPost');
Route::get('mostSharePost', 'API\FontendController@mostSharePost');
Route::get('relatedArticles/{id}', 'API\FontendController@relatedArticles');
Route::post('addLike/{user}/{post}', 'API\FontendController@addLike');
Route::post('deleteLike/{user}/{post}', 'API\FontendController@deleteLike');