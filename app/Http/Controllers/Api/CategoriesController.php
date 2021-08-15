<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Category;

class CategoriesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$categories = Category::where('active', 1)->get();
		foreach ($categories as $category) {
			$category->products();
		}
		return response()->json(['response' => $categories], Response::HTTP_OK);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store()
	{
		request()->validate([
			'name' => ['required', 'string'],
			'description' => ['sometimes', 'string'],
		]);
		request()->user_id = request()->user()->id;
		$category = Category::create(request()->only(['name', 'description', 'user_id']));
		return response()->json(['response' => $category], Response::HTTP_OK);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return response()->json(['response' => Category::findOrFail($id)], Response::HTTP_OK);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update($id)
	{
		request()->validate([
			'name' => ['required', 'string'],
			'description' => ['required', 'string'],
		]);
		$category = Category::where('id', $id)->update(request()->only(['name', 'description']));
		return response()->json(['response' => $category], Response::HTTP_OK);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$category = Category::where('id', $id)->update(['active' => 0]);
		return response()->json(['response' => $category], Response::HTTP_OK);
	}
}
