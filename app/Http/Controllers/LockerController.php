<?php

namespace App\Http\Controllers;

use App\Locker;
use Illuminate\Http\Request;
use App\Area;
use App\Course;
use App\Typology;
use App\GridHelper;

class LockerController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$nome = $request->nome;
		$local = $request->local;
		$topologia = $request->topologia;
		$order = $request->order;
		$areas = Area::orderBy('nome','asc')->get();
		$typologies = Typology::orderBy('nome','asc')->get();

		$lockers = Locker::leftJoin('areas', 'lockers.area_id', '=', 'areas.id')
			->leftJoin('typologies', 'lockers.typology_id', '=', 'typologies.id')
			->select('lockers.id as id', 'lockers.nome as nome', 'areas.nome as local', 'typologies.nome as topologia')
			->when($nome, function ($query, $nome) {
				return $query->where('lockers.nome', 'LIKE', "%$nome%");
			})
			->when($local, function ($query, $local) {
				return $query->where('lockers.area_id', $local);
			})
			->when($topologia, function ($query, $topologia) {
				return $query->where('lockers.typology_id', $topologia);
			})
			->when($order, function ($query, $order) {
				switch ($order) {
					case 'nome':
						return $query->orderBy('lockers.nome');
					case 'local':
						return $query->orderBy('areas.nome');
					case 'topologia':
						return $query->orderBy('typologies.nome');
					default:
						return $query->orderBy('lockers.id', 'DESC');
				}
			}, function ($query) {
				return $query->orderBy('lockers.id', 'DESC');
			})
			->paginate(10);
		return view('settings.c.locker.index')->with(compact('lockers'))
			->with(compact('areas'))
			->with(compact('typologies'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$areas = Area::orderBy('nome','asc')->get();
		$typologies = Typology::orderBy('nome','asc')->get();
		return view('settings.c.locker.create')
			->with(compact('areas'))
			->with(compact('typologies'));
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
			'nome' => 'required|string|max:255|unique:lockers,nome',
			'area' => 'numeric|required',
			'typology' => 'numeric|required',
		]);
		$locker = new Locker();
		$locker->nome = $request->nome;
		$locker->area_id = $request->area;
		$locker->typology_id = $request->typology;
		$locker->save();
		GridHelper::setOption("cacifos", Course::count(), "count");
		return redirect('/definicoes/c/cacifos')->with('success','Adicionado com sucesso.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return redirect('/definicoes/c/cacifos/' . $id . '/edit');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$areas = Area::orderBy('nome','asc')->get();
		$typologies = Typology::orderBy('nome','asc')->get();
		$locker = Locker::find($id);
		return view('settings.c.locker.edit')
			->with(compact('locker'))
			->with(compact('areas'))
			->with(compact('typologies'));
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
			'nome' => 'required|string|max:255|unique:lockers,nome,' . $id, 
			'area' => 'required|not_in:0',
			'typology' => 'required|not_in:0',
		]);
		$locker = Locker::find($id);
		$locker->nome = $request->nome;
		$locker->area_id = $request->area;
		$locker->typology_id = $request->typology;
		$locker->save();
		GridHelper::setOption("cacifos", Locker::count(), "count");
		return redirect('/definicoes/c/cacifos')->with('success','Editado com sucesso.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		Locker::destroy($id);
		GridHelper::setOption("cacifos", Course::count(), "count");
		return redirect('/definicoes/c/cacifos')->with('success','Apagado com sucesso.');
	}
}
