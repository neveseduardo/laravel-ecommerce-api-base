<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Product;

class ProductsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$products = Product::with('category')->with('user')->withCount('likes')->where('active', 1)->get();
		return response()->json(['response' => $products, 'count' => $products->count()], Response::HTTP_OK);
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
			'title' 		=> ['required', 'string'],
			'price' 		=> ['required'],
			'quantity' 		=> ['required'],
			'image' 		=> ['sometimes', 'image', 'mimes:jpeg,bmp,png,gif', 'max:2048'],
			'category_id' 	=> ['required'],
		]);
		$data = request()->only(['title', 'description', 'price', 'quantity', 'image', 'category_id']);
		$data['user_id'] = request()->user()->id;
		$product = Product::create($data);
		return response()->json(['response' => $product], Response::HTTP_OK);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$product = Product::with('category')->with('user')->withCount('likes')->findOrFail($id);
		return response()->json(['response' => $product], Response::HTTP_OK);
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
			'title' 		=> ['required'],
			'price' 		=> ['required'],
			'quantity' 		=> ['required'],
			'image' 		=> ['sometimes', 'image', 'mimes:jpeg,bmp,png,gif', 'max:2048'],
			'category_id' 	=> ['required'],
		]);
		$product = Product::findOrFail($id);
		$product->update(request()->only(['title', 'description', 'price', 'quantity', 'image', 'category_id']));
		return response()->json(['response' => $product], Response::HTTP_OK);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id)
	{
		Product::findOrFail($id)->update(['active' => 0]);
		return response()->json(['response' => 'Desativado com sucesso.'], Response::HTTP_OK);
	}
}
