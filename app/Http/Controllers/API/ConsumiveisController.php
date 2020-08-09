<?php

namespace App\Http\Controllers\API;

use App\GridHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\ProductCategory;

class ConsumiveisController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth:api');
	}

	public function listAllConsumiveis(Request $request)
	{
		try {
			$nome = $request->nome;
			$categoria = $request->categoria;
			$order = $request->order;

			$consumiveis = Product::leftJoin('product_categories', 'product_categories.id', 'products.category_id')
				->select('products.id', 'products.nome', 'products.quantidade', 'product_categories.nome as categoria', 'products.cor')
				->addSelect(\DB::raw('0 as stock'))
				->when($categoria, function ($query, $categoria) {
					return $query->where('products.category_id', $categoria);
				})
				->when($nome, function ($query, $nome) {
					return $query->where('products.nome', 'LIKE', "%$nome%");
				})
				->when($order, function ($query, $order) {
					switch ($order) {
						case 'nome':
							return $query->orderBy('products.nome', 'ASC');
						case 'categoria':
							return $query->orderBy('product_categories.nome', 'ASC');
						case 'quantidade':
							return $query->orderBy('products.quantidade', 'ASC');
						default:
							return $query->orderBy('products.nome', 'ASC');
					}
				}, function ($query) {
					return $query->orderBy('products.nome', 'ASC');
				})
				->paginate(10);
			return response()->json($consumiveis);
		} catch (\Exception $e) {
			return response()->json(null, 500);
		}
	}

	public function getAllCategories()
	{
		try {
			$categorias = ProductCategory::select('product_categories.id', 'product_categories.nome')
				->orderBy('product_categories.nome', 'asc')
				->get();
			return response()->json($categorias);
		} catch (\Exception $e) {
			return response()->json(null, 500);
		}
	}

	public function updateConsumivel(Request $request, $id)
	{
		try {
			$consumivel = Product::findOrFail($id);
			if($consumivel->quantidade != $request->consumivel["quantidade"]){
				return response()->json(null, 406);
			}
			$consumivel->quantidade = intval($request->consumivel["quantidade"]) + intval($request->consumivel["stock"]);
			$consumivel->save();
			
			GridHelper::logger("CONS", "UPDT", Auth::user()->id, $consumivel->id, $request->consumivel["quantidade"], $consumivel->quantidade);

			return response()->json($consumivel, 202);
		} catch (\Exception $e) {
			return response()->json(null, 500);
		}
	}
}
