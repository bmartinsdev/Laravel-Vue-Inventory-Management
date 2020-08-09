<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Unit;

class StatsController extends Controller
{
	public function baixasInventarioLocais()
	{
		try {
			$total = Unit::onlyTrashed()->count();
			$salas = Unit::leftJoin('rooms', 'units.room_id', 'rooms.id')
				->select('rooms.id', DB::raw('count(units.id) as count'), 'rooms.nome')
				->groupBy('rooms.id', 'rooms.nome')
				->onlyTrashed()
				->orderBy('count', 'desc')
				->limit(6)
				->get();
			return response()->json(["salas" => $salas, "total" => $total], 200);
		} catch (\Exception $e) {
			return response()->json(null, 500);
		}
	}

	public function baixasinventario()
	{
		try {
			$invs = Unit::Join('inventories', 'units.room_id', 'inventories.id')
				->select('inventories.id', DB::raw('count(units.id) as count'), 'inventories.nome')
				->groupBy('inventories.id', 'inventories.nome')
				->onlyTrashed()
				->orderBy('count', 'desc')
				->limit(6)
				->get();
			return response()->json($invs, 200);
		} catch (\Exception $e) {
			return response()->json(null, 500);
		}
	}

	public function baixasconsumiveis()
	{
		try {
			$logs = DB::table('gridlogs')
				->select(DB::raw('count(*) as count'))
				->selectRaw("MONTH(created_at) as month")
				->groupBy('month')
				->orderBy('month', 'asc')
				->get();
			return response()->json($logs, 200);
		} catch (\Exception $e) {
			return response()->json(null, 500);
		}
	}

	public function listarLogs(Request $request)
	{
		try {
			$order = $request->order;

			$logs = DB::table('gridlogs')
				->select('gridlogs.user_id', 'gridlogs.page', 'gridlogs.target_id', 'gridlogs.old_value', 'gridlogs.new_value', 'gridlogs.created_at')
				->when($order, function ($query, $order) {
					switch ($order) {
						case 'user':
							return $query->orderBy('gridlogs.user_id', 'ASC');
						case 'page':
							return $query->orderBy('gridlogs.page', 'ASC');
						case 'created':
							return $query->orderBy('gridlogs.created_at', 'DESC');
						default:
							return $query->orderBy('gridlogs.id', 'DESC');
					}
				}, function ($query) {
					return $query->orderBy('gridlogs.id', 'DESC');
				})
				->paginate(10);
			return response()->json($logs);
		} catch (\Exception $e) {
			return response()->json(null, 500);
		}
	}
}
