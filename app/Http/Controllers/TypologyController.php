<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Typology;
use App\GridHelper;

class TypologyController extends Controller
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
		$typologies = Typology::select('typologies.id', 'typologies.nome')
			->when($nome, function ($query, $nome) {
				return $query->where('typologies.nome', 'LIKE', "%$nome%");
			})
			->when($order, function ($query, $order) {
				switch ($order) {
					case 'nome':
						return $query->orderBy('typologies.nome');
					case 'id':
						return $query->orderBy('typologies.id', 'DESC');
				}
			}, function ($query) {
				return $query->orderBy('typologies.id', 'DESC');
			})
			->paginate(10);
		return view('settings.c.typology.index')->with(compact('typologies'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('settings.c.typology.create');
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
			'nome' => 'required|string|max:255|unique:typologies,nome',
		]);
		$typology = new Typology();
		$typology->nome = $request->nome;
		$typology->save();
		GridHelper::setOption("topologias", Typology::count(), "count");
		return redirect('/definicoes/c/topologias')->with('success','Adicionado com sucesso.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return redirect('/definicoes/c/topologias/' . $id . '/edit');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$typology = Typology::find($id);
		return view('settings.c.typology.edit')
			->with(compact('typology'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$request->validate([
			'nome' => 'required|string|max:255|unique:typologies,nome,' . $id,
		]);
		$typology = Typology::find($id);
		$typology->nome = $request->nome;
		$typology->save();
		return redirect('/definicoes/c/topologias')->with('success','Editado com sucesso.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		Typology::destroy($id);
		GridHelper::setOption("topologias", Typology::count(), "count");
		return redirect('/definicoes/c/topologias')->with('success','Apagado com sucesso.');
	}
}
