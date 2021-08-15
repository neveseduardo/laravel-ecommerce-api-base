<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Product;
use DB;

class ProductsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$products = Product::with('category')->with('user')->withCount('likes')->where('active', 1)->orderBy('id', 'desc')->get();
		return response()->json(['response' => $products, 'count' => $products->count()], Response::HTTP_OK);
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
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store()
	{
		DB::beginTransaction();
		try {
			request()->validate([
				'title' 		=> ['required', 'string'],
				'price' 		=> ['required'],
				'quantity' 		=> ['required'],
				'image' 		=> ['sometimes', 'image', 'mimes:jpeg,bmp,png,gif', 'max:2048'],
				'category_id' 	=> ['required'],
			]);

			$data = request()->only(['title', 'description', 'price', 'quantity', 'image', 'category_id']);
			$data['user_id'] = request()->user()->id;
			$images = [];
			if (request()->hasFile('image')) {
				foreach (request()->file('image') as $file) {
					$images[] = FileHelper::fileUpload($file, null, null, 'products');
				}
			}
			$data['image'] = implode(',', $images);
			$product = Product::create($data);
			DB::commit();
			return response()->json(['response' => $product], Response::HTTP_OK);
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
			request()->validate([
				'title' 		=> ['required'],
				'price' 		=> ['required'],
				'quantity' 		=> ['required'],
				'image' 		=> ['sometimes', 'image', 'mimes:jpeg,bmp,png,gif', 'max:2048'],
				'category_id' 	=> ['required'],
			]);
			$product = Product::findOrFail($id);
			$data = request()->only(['title', 'description', 'price', 'quantity', 'image', 'category_id']);
			$images = [];
			if (request()->hasFile('image')) {
				foreach (request()->file('image') as $file) {
					$images[] = FileHelper::fileUpload($file, null, null, 'products');
				}
			}
			$data['image'] = implode(',', $images);
			$product->update($data);
			DB::commit();
			return response()->json(['response' => $product], Response::HTTP_OK);
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
			Product::findOrFail($id)->update(['active' => 0]);
			DB::commit();
			return response()->json(['response' => 'Desativado com sucesso.'], Response::HTTP_OK);
		} catch (Exception $e) {
			DB::rollback();
		}
	}
}
