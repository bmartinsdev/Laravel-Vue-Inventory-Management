<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GridHelper;


class InventoryController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$nome = $request->nome;
		$custo = $request->custo;
		$order = $request->order;
		$inventories = Inventory::select('inventories.id', 'inventories.nome', 'inventories.custo', 'inventories.count_unidades')
			->when($nome, function ($query, $nome) {
				return $query->where('inventories.nome', 'LIKE', "%$nome%");
			})
			->when($custo, function ($query, $custo) {
				return $query->where('inventories.custo', $custo);
			})
			->when($order, function ($query, $order) {
				switch ($order) {
					case 'nome':
						return $query->orderBy('inventories.nome');
					case 'count_unidades':
						return $query->orderBy('inventories.count_unidades');
					case 'id':
						return $query->orderBy('inventories.id', 'DESC');
				}
			}, function ($query) {
				return $query->orderBy('inventories.id', 'DESC');
			})
			->paginate(10);
		return view('settings.i.inventory.index')->with(compact('inventories'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('settings.i.inventory.create');
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
			'nome' => 'required|string|max:255|unique:inventories,nome',
			'altura' => 'numeric|nullable',
			'largura' => 'numeric|nullable',
			'comprimento' => 'numeric|nullable',
			'unidade_medida' => 'string|nullable',
			'custo' => 'required|int',
		]);

		$inventory = new Inventory();
		$inventory->nome = $request->nome;
		$inventory->altura = $request->altura;
		$inventory->largura = $request->largura;
		$inventory->comprimento = $request->comprimento;
		$inventory->unidade_medida = $request->unidade_medida;
		$inventory->custo = $request->custo;
		$inventory->save();

		GridHelper::setOption("inventarios", Inventory::count(), "count");
		return redirect('/definicoes/i/inventarios/' . $inventory->id . '/edit')->with('success','Adicionado com sucesso.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Inventory  $inventory
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return redirect('/definicoes/i/inventarios/' . $id . '/edit');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Inventory  $inventory
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$inventory = Inventory::find($id);
		$unidades = Unit::where('inventory_id', $id)->paginate(12);
		return view('settings.i.inventory.edit')
			->with(compact('inventory'))
			->with(compact('unidades'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Inventory  $inventory
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$request->validate([
			'nome' => 'required|string|max:255|unique:inventories,nome,' . $id,
			'altura' => 'numeric|nullable',
			'largura' => 'numeric|nullable',
			'comprimento' => 'numeric|nullable',
			'unidade_medida' => 'string|nullable',
			'custo' => 'required|int',
		]);
		$inventory = Inventory::find($id);
		$inventory->nome = $request->nome;
		$inventory->altura = $request->altura;
		$inventory->largura = $request->largura;
		$inventory->comprimento = $request->comprimento;
		$inventory->unidade_medida = $request->unidade_medida;
		$inventory->custo = $request->custo;
		$inventory->save();
		return redirect('/definicoes/i/inventarios/' . $id . '/edit')->with('success','Editado com sucesso.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Inventory  $inventory
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		Inventory::destroy($id);
		GridHelper::setOption("inventarios", Inventory::count(), "count");
		return redirect('/definicoes/i/inventarios')->with('success','Apagado com sucesso.');
	}


	/**
	 * ADICIONAR UNIDADES
	 */
	public function adicionarUnidades(Request $request, $inventoryID)
	{
		try {
			$failed = [];
			foreach ($request->unidades as $u) {
				try {
					$unit = new Unit();
					$unit->codigo = $u;
					$unit->inventory_id = $inventoryID;
					$unit->room_id = 1;
					$unit->saveOrFail();
				} catch (\Exception $e) {
					array_push($failed, $u);
				}
			}
			return redirect('/definicoes/i/inventarios/' . $inventoryID . '/edit')->with('success','Adicionado com sucesso.');
		} catch (\Exception $e) {
			return redirect('/definicoes/i/inventarios/' . $inventoryID . '/edit')->with('warning','Algo falhou.');
		}
	}

	public function apagarUnidade($inventoryID, $unidadeID)
	{
		Unit::destroy($unidadeID);
		return redirect('/definicoes/i/inventarios/' . $inventoryID . '/edit')->with('success','Apagado com sucesso.');
	}
}
