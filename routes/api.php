<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;

Route::namespace('Api')->group(function () {
	Route::namespace('Auth')->group(function () {
		Route::group(['prefix' => 'auth'], function () {
			Route::post('login', 'AuthController@login');
			Route::post('register', 'AuthController@register');

			Route::group(['middleware' => 'auth:api'], function () {
				Route::get('logout', 'AuthController@logout');
				Route::get('user', 'AuthController@user');
			});
		});
	});
});


Route::fallback(function () {
	return response()->json(['response' => 'Rota não encontrada'], Response::HTTP_NOT_FOUND);
});
