<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;

class AuthController extends Controller
{
	/**
	 * Create user
	 *
	 * @param  [string] name
	 * @param  [string] email
	 * @param  [string] password
	 * @param  [string] password_confirmation
	 * @return [string] message
	 */
	public function register()
	{
		request()->validate([
			'name' 		=> ['required', 'string'],
			'email' 	=> ['required', 'string', 'email', 'unique:users'],
			'password' 	=> ['required', 'string', 'confirmed']
		]);
		$data = request()->only(['name', 'email', 'password']);
		$data['password'] = \Hash::make($data['password']);
		User::create($data);
		return response()->json(['message' => 'Cadastrado com sucesso!',], Response::HTTP_OK);
	}

	/**
	 * Login user and create token
	 *
	 * @param  [string] email
	 * @param  [string] password
	 * @param  [boolean] remember_me
	 * @return [string] access_token
	 * @return [string] token_type
	 * @return [string] expires_at
	 */
	public function login()
	{
		request()->validate([
			'email' 		=> ['required', 'string', 'email'],
			'password' 		=> ['required', 'string'],
			'remember_me' 	=> ['boolean']
		]);
		$credentials = request()->only(['email', 'password']);
		if (!Auth::attempt($credentials))
			return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
		$user = request()->user();
		$tokenResult = $user->createToken('Personal Access Token');
		$token = $tokenResult->token;
		if (request('remember_me'))
			$token->expires_at = Carbon::now()->addWeeks(1);
		$token->save();
		return response()->json([
			'token' => $tokenResult->accessToken,
			'expires_at' => Carbon::parse(
				$tokenResult->token->expires_at
			)->toDateTimeString()
		], Response::HTTP_OK);
	}

	/**
	 * Logout user (Revoke the token)
	 *
	 * @return [string] message
	 */
	public function logout()
	{
		request()->user()->token()->revoke();
		return response()->json([
			'message' => 'Saiu com sucesso!'
		], Response::HTTP_OK);
	}

	/**
	 * Get the authenticated User
	 *
	 * @return [json] user object
	 */
	public function user()
	{
		return response()->json(request()->user(), Response::HTTP_OK);
	}
}
