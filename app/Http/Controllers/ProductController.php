<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GridHelper;

class ProductController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$nome = $request->nome;
		$categoria = $request->categoria;
		$order = $request->order;
		$pcategories = ProductCategory::orderBy('nome','asc')->get();

		$products = Product::leftJoin('product_categories', 'products.category_id', '=', 'product_categories.id')
			->select('products.id', 'products.nome', 'product_categories.nome as categoria', 'products.quantidade')
			->when($nome, function ($query, $nome) {
				return $query->where('products.nome', 'LIKE', "%$nome%");
			})
			->when($categoria, function ($query, $categoria) {
				return $query->where('products.category_id', $categoria);
			})
			->when($order, function ($query, $order) {
				switch ($order) {
					case 'nome':
						return $query->orderBy('products.nome');
					case 'categoria':
						return $query->orderBy('product_categories.nome');
					case 'quantidade':
						return $query->orderBy('products.quantidade');
					case 'id':
						return $query->orderBy('products.id', 'DESC');
				}
			}, function ($query) {
				return $query->orderBy('products.id', 'DESC');
			})
			->paginate(10);
		return view('settings.s.product.index')->with(compact('products'))
			->with(compact('pcategories'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$pcategories = ProductCategory::orderBy('nome','asc')->get();
		return view('settings.s.product.create')->with(compact('pcategories'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$request->validate([
			'nome' => 'required|string|max:255|unique:products,nome',
			'quantidade' => 'numeric|required',
			'category' => 'numeric|required',
		]);
		$product = new Product();
		$product->nome = $request->nome;
		$product->quantidade = $request->quantidade;
		$product->category_id = $request->category;
		$product->save();
		GridHelper::setOption("produtos", Product::count(), "count");
		return redirect('/definicoes/s/produtos')->with('success','Adicionado com sucesso.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return redirect('/definicoes/s/produtos/' . $id . '/edit');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$product = Product::find($id);
		$pcategories = ProductCategory::orderBy('nome','asc')->get();
		return view('settings.s.product.edit')->with(compact('product'))->with(compact('pcategories'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$request->validate([
			'nome' => 'required|string|max:255|unique:products,nome,' . $id,
			'quantidade' => 'numeric|required',
			'category' => 'numeric|required',
		]);
		$product = Product::find($id);
		$product->nome = $request->nome;
		$product->quantidade = $request->quantidade;
		$product->category_id = $request->category;
		$product->save();
		return redirect('/definicoes/s/produtos')->with('success','Editado com sucesso.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		Product::destroy($id);
		GridHelper::setOption("produtos", Product::count(), "count");
		return redirect('/definicoes/s/produtos')->with('success','Apagado com sucesso.');
	}
}
