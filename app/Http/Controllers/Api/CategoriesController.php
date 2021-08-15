<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Models\Category;
use DB;

class CategoriesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$categorys = Category::with('products')->with('user')->where('active', 1)->get();
		return response()->json(['response' => $categorys, 'count' => $categorys->count()], Response::HTTP_OK);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$category = Category::with('products')->with('user')->findOrFail($id);
		return response()->json(['response' => $category], Response::HTTP_OK);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store()
	{
		DB::beginTransaction();
		try {
			request()->validate(['name' => ['required', 'string']]);
			$data = request()->only(['name', 'description']);
			$data['user_id'] = request()->user()->id;
			$category = Category::create($data);
			DB::commit();
			return response()->json(['response' => $category], Response::HTTP_OK);
		} catch (Exception $e) {
			DB::rollback();
		}
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
		DB::beginTransaction();
		try {
			request()->validate(['name' => ['required']]);
			$category = Category::findOrFail($id);
			$category->update(request()->only(['name']));
			DB::commit();
			return response()->json(['response' => $category], Response::HTTP_OK);
		} catch (Exception $e) {
			DB::rollback();
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id)
	{
		DB::beginTransaction();
		try {
			Category::findOrFail($id)->update(['active' => 0]);
			\App\Models\Product::where('cod_category', $id)->update(['active' => 0]);
			DB::commit();
			return response()->json(['response' => 'Desativado com sucesso.'], Response::HTTP_OK);
		} catch (Exception $e) {
			DB::rollback();
		}
	}
}
