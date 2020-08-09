<?php

namespace App\Http\Controllers;

use App\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GridHelper;

class AreaController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$filtro = $request->search;
		$order = $request->order;
		$areas = Area::select('areas.id', 'areas.nome')
			->when($filtro, function ($query, $filtro) {
				return $query->where('areas.nome', 'LIKE', "%$filtro%");
			})
			->when($order, function ($query, $order) {
				switch ($order) {
					case 'nome':
						return $query->orderBy('areas.nome');
					case 'id':
						return $query->orderBy('areas.id', 'DESC');
			}
			}, function ($query) {
				return $query->orderBy('areas.id', 'DESC');
			})
			->paginate(10);
		return view('settings.c.area.index')->with(compact('areas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('settings.c.area.create');
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
		]);
		$area = new Area();
		$area->nome = $request->nome;
		$area->save();
		GridHelper::setOption("locais", Area::count(), "count");
		return redirect('/definicoes/c/locais')->with('success','Adicionado com sucesso.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Area  $area
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return redirect('/definicoes/c/locais/' . $id . '/edit');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Area  $area
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$area = Area::find($id);
		return view('settings.c.area.edit')
			->with(compact('area'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Area  $area
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$request->validate([
			'nome' => 'required|string|max:255|unique:areas,nome,' . $id,
		]);
		$area = Area::find($id);
		$area->nome = $request->nome;
		$area->save();
		return redirect('/definicoes/c/locais')->with('success','Editado com sucesso.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Area  $area
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		Area::destroy($id);
		GridHelper::setOption("locais", Area::count(), "count");
		return redirect('/definicoes/c/locais')->with('success','Apagado com sucesso.');
	}
}
