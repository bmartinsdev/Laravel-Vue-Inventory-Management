<?php

namespace App\Http\Controllers;

use App\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GridHelper;


class ProductCategoryController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$nome = $request->nome;
		$order = $request->order;

		$pcategories = ProductCategory::select('product_categories.id', 'product_categories.nome', 'product_categories.avgref')
			->when($nome, function ($query, $nome) {
				return $query->where('product_categories.nome', 'LIKE', "%$nome%");
			})
			->when($order, function ($query, $order) {
				switch ($order) {
					case 'nome':
						return $query->orderBy('product_categories.nome');
					case 'avgref':
						return $query->orderBy('product_categories.avgref');
					case 'id':
						return $query->orderBy('product_categories.id', 'DESC');
				}
			}, function ($query) {
				return $query->orderBy('product_categories.id', 'DESC');
			})
			->paginate(10);
		return view('settings.s.category.index')->with(compact('pcategories'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('settings.s.category.create');
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
			'nome' => 'required|string|max:255|unique:areas,nome',
			'avgref' => 'numeric|required',
		]);
		$pcategory = new ProductCategory();
		$pcategory->nome = $request->nome;
		$pcategory->avgref = $request->avgref;
		$pcategory->save();
		GridHelper::setOption("categorias", ProductCategory::count(), "count");
		return redirect('/definicoes/s/categorias')->with('success','Adicionado com sucesso.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\ProductCategory  $productCategory
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return redirect('/definicoes/s/categorias/' . $id . '/edit');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\ProductCategory  $productCategory
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$pcategory = ProductCategory::find($id);
		return view('settings.s.category.edit')->with(compact('pcategory'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\ProductCategory  $productCategory
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$request->validate([
			'nome' => 'required|string|max:255|unique:areas,nome,' . $id,
			'avgref' => 'numeric|required',
		]);
		$pcategory = ProductCategory::find($id);
		$pcategory->nome = $request->nome;
		$pcategory->avgref = $request->avgref;
		$pcategory->save();
		return redirect('/definicoes/s/categorias')->with('success','Editado com sucesso.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\ProductCategory  $productCategory
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		ProductCategory::destroy($id);
		GridHelper::setOption("categorias", ProductCategory::count(), "count");
		return redirect('/definicoes/s/categorias')->with('success','Apagado com sucesso.');
	}
}
