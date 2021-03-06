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

Route::get('/books', 'BooksController@index');
Route::group([
    'middleware' => 'auth:api'
], function() {
    Route::post('/books/{id}/reviews', 'BooksReviewController@store');
    Route::group([
        'middleware' => 'auth.admin'
    ], function() {
        Route::post('/books', 'BooksController@store');
        Route::delete('/books/{bookId}/reviews/{reviewId}', 'BooksReviewController@destroy');
    });
});
