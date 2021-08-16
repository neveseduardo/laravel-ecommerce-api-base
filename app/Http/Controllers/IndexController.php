<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class IndexController extends Controller
{
    public function index () {
		return response()->json(['response' => 'Bem vindo a API de ecommerce com laravel'], Response::HTTP_OK);
	}
}
