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

	Route::group(['prefix' => 'protected', 'middleware' => 'auth:api'], function () {
		Route::group(['prefix' => 'product'], function () {
			Route::get('/', 'ProductsController@index');
			Route::get('/{id}', 'ProductsController@show')->where(['id' => '[0-9]+']);
			Route::post('/store', 'ProductsController@store');
			Route::post('/update/{id}', 'ProductsController@update')->where(['id' => '[0-9]+']);
			Route::post('/delete/{id}', 'ProductsController@delete')->where(['id' => '[0-9]+']);
		});

		Route::group(['prefix' => 'category'], function () {
			Route::get('/', 'CategoriesController@index');
			Route::get('/{id}', 'CategoriesController@show')->where(['id' => '[0-9]+']);
			Route::post('/store', 'CategoriesController@store');
			Route::post('/update/{id}', 'CategoriesController@update')->where(['id' => '[0-9]+']);
			Route::post('/delete/{id}', 'CategoriesController@delete')->where(['id' => '[0-9]+']);
		});
	});

	Route::group(['prefix' => 'opened'], function () {
		Route::group(['prefix' => 'products'], function () {
			Route::get('/', 'ProductsController@index');
			Route::get('/{id}', 'ProductsController@show')->where(['id' => '[0-9]+']);
		});
		Route::group(['prefix' => 'category'], function () {
			Route::get('/', 'ProductsController@index');
			Route::get('/{id}', 'ProductsController@show')->where(['id' => '[0-9]+']);
		});
	});
});


Route::fallback(function () {
	return response()->json(['response' => 'Rota não encontrada'], Response::HTTP_NOT_FOUND);
});
