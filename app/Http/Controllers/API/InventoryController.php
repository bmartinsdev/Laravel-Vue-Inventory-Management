<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Unit;
use App\Room;
use App\GridHelper;

class InventoryController extends Controller
{

	public function __construct(){
	    $this->middleware('auth:api');
	}

	public function getAllRooms()
	{
		try {
			$rooms = Room::select('id', 'nome')->addSelect(\DB::raw('false as toggle'))->get();
			return response()->json($rooms);
		} catch (\Exception $e) {
			return response()->json(null, 500);
		}
	}

	public function getRoomInventory(Request $request, $sala)
	{
		try {
			$filtro = $request->search;
			$custo = $request->custo;
			
			$roominv = Unit::leftJoin('inventories', 'inventories.id', '=', 'units.inventory_id')
				->select('units.codigo', 'units.inventory_id', 'units.room_id', 'inventories.nome', 'inventories.altura', 'inventories.largura', 'inventories.comprimento', 'inventories.unidade_medida', 'inventories.custo')
				->orderBy('units.room_id', 'asc')
				->where('units.room_id', '=', $sala)
				->when($custo, function ($query, $custo) {
					return $query->where('inventories.custo', $custo);
				})
				->when($filtro, function ($query, $filtro) {
					return $query->where('inventories.nome', 'LIKE', "%$filtro%")
						->orWhere('units.codigo', 'LIKE', "%$filtro%");
				})
				->get();
			return response()->json($roominv);
		} catch (\Exception $e) {
			return response()->json(null, 500);
		}
	}

	public function getUnits(Request $request)
	{
		try {
			$filtro = $request->search;
			$custo = $request->custo;
			$roominv = [];
			if (!$filtro && !$custo)
				return $roominv;

			$roominv = Unit::leftJoin('inventories', 'inventories.id', '=', 'units.inventory_id')
				->select('units.codigo', 'units.inventory_id', 'units.room_id', 'inventories.nome', 'inventories.altura', 'inventories.largura', 'inventories.comprimento', 'inventories.unidade_medida', 'inventories.custo')
				->orderBy('units.room_id', 'asc')
				->when($filtro, function ($query, $filtro) {
					return $query->where(function($q) use($filtro) {
						$q->where('inventories.nome', 'LIKE', "%$filtro%")
						->orWhere('units.codigo', 'LIKE', "%$filtro%");
					});
				})
				->when($custo, function ($query, $custo) {
					return $query->where('inventories.custo', $custo);
				})
				->get();
			return response()->json($roominv);
		} catch (\Exception $e) {
			return response()->json(null, 500);
		}
	}

	public function moveInventory(Request $request, $sala, $codigo)
	{
		try {
			$unit = Unit::where('codigo', $codigo)->firstOrFail();
			if ($unit->room_id == $sala && $request->target) {
				$unit->room_id = $request->target;
				$unit->save();
				
				GridHelper::logger("INVT", "MOVE", Auth::user()->id, $unit->id, $sala, $request->target);
				return response($unit, 202);
			}
			return response($unit, 406);
		} catch (\Exception $e) {
			return response()->json(null, 500);
		}
	}

	public function bulkMoveInventory(Request $request, $sala)
	{
		try {
			$success = [];
			$failed = [];
			foreach ($request->listaCodigos as $codigo) {
				try {
					$unit = Unit::where('codigo', $codigo)->firstOrFail();
				} catch (\Exception $e) {
					array_push($failed, $codigo);
				}
				if ($unit->room_id == $sala && $request->target) {
					$unit->room_id = $request->target;
					$unit->save();
					
					GridHelper::logger("INVT", "MOVE", Auth::user()->id, $unit->id, $sala, $request->target);

					array_push($success, $codigo);
				} else {
					array_push($failed, $codigo);
				}
			}
			return response(["success" => $success, "failed" => $failed, "target" => $sala], 202);
		} catch (\Exception $e) {
			return response()->json(null, 500);
		}
	}
}
