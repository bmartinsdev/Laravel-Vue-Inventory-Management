<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;
use App\GridHelper;

class RoomController extends Controller
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
		$rooms = Room::select('rooms.id', 'rooms.nome')
			->when($nome, function ($query, $nome) {
				return $query->where('rooms.nome', 'LIKE', "%$nome%");
			})
			->when($order, function ($query, $order) {
				switch ($order) {
					case 'nome':
						return $query->orderBy('rooms.nome');
					case 'id':
						return $query->orderBy('rooms.id', 'DESC');
				}
			}, function ($query) {
				return $query->orderBy('rooms.id', 'DESC');
			})
			->paginate(10);
		return view('settings.i.rooms.index')->with(compact('rooms'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$rooms = Room::all();
		return view('settings.i.rooms.create')->with(compact('rooms'));
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
			'nome' => 'required|string|max:255|unique:rooms,nome',
		]);
		$room = new Room();
		$room->nome = $request->nome;
		$room->save();
		GridHelper::setOption("salas", Room::count(), "count");
		return redirect('/definicoes/i/salas')->with('success','Adicionado com sucesso.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Room  $room
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return redirect('/definicoes/i/salas/' . $id . '/edit');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Room  $room
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$room = Room::find($id);
		return view('settings.i.rooms.edit')->with(compact('room'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Room  $room
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$request->validate([
			'nome' => 'required|string|max:255|unique:rooms,nome,' . $id,
		]);
		$room = Room::find($id);
		$room->nome = $request->nome;
		$room->save();
		return redirect('/definicoes/i/salas')->with('success','Editado com sucesso.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Room  $room
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		Room::destroy($id);
		GridHelper::setOption("salas", Room::count(), "count");
		return redirect('/definicoes/i/salas')->with('success','Apagado com sucesso.');
	}
}
