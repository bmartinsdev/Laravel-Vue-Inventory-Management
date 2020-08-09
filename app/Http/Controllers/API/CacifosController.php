<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Locker;
use App\Student;
use App\State;
use App\Area;
use App\Typology;
use App\GridHelper;

class CacifosController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth:api');
	}

	public function listAllCacifos(Request $request)
	{
		try {
			$nome = $request->nome;
			$aluno = $request->aluno;
			$estado = $request->estado;
			$local = $request->local;
			$topologia = $request->topologia;
			$order = $request->order;

			$cacifos = Locker::leftJoin('typologies', 'typologies.id', 'lockers.typology_id')
				->leftJoin('areas', 'areas.id', 'lockers.area_id')
				->leftJoin('states', 'states.id', 'lockers.state_id')
				->leftJoin('students', 'students.locker_id', 'lockers.id')
				->leftJoin('courses', 'courses.id', 'students.course_id')
				->select('lockers.id', 'lockers.nome', 'states.nome as estado', 'areas.nome as local', 'typologies.nome as topologia')
				->with(array('students' => function ($query) {
					$query->leftJoin('courses', 'students.course_id', 'courses.id')
						->select('students.id', 'students.codigo', 'students.nome', 'courses.nome as turma', 'students.locker_id');
				}))
				->when($estado, function ($query, $estado) {
					return $query->where('states.id', $estado);
				})
				->when($local, function ($query, $local) {
					return $query->where('areas.id', $local);
				})
				->when($topologia, function ($query, $topologia) {
					return $query->where('typologies.id', $topologia);
				})
				->when($nome, function ($query, $nome) {
					return $query->where('lockers.nome', 'LIKE', "%$nome%");
				})
				->when($aluno, function ($query, $aluno) {
					return $query->where(function ($q) use ($aluno) {
						$q->where('students.codigo', 'LIKE', "%$aluno%")
							->orWhere('students.nome', 'LIKE', "%$aluno%")
							->orWhere('courses.nome', 'LIKE', "%$aluno%");
					});
				})
				->when($order, function ($query, $order) {
					switch ($order) {
						case 'nome':
							return $query->orderBy('lockers.nome', 'ASC');
						case 'estado':
							return $query->orderBy('states.nome', 'ASC');
						case 'local':
							return $query->orderBy('areas.nome', 'ASC');
						case 'topologia':
							return $query->orderBy('typologies.nome', 'ASC');
						default:
							return $query->orderBy('lockers.id', 'ASC');
					}
				}, function ($query) {
					return $query->orderBy('lockers.nome', 'ASC');
				})
				->groupBy('lockers.id', 'lockers.nome', 'states.nome', 'areas.nome', 'typologies.nome')
				->paginate(10);
			return response()->json($cacifos);
		} catch (\Exception $e) {
			return response()->json(null, 500);
		}
	}

	public function filteredAlunos(Request $request)
	{
		try {
			$filtro = $request->filtro;
			$cacifo = $request->cacifo;
			$alunos = Student::leftJoin('courses', 'students.course_id', 'courses.id')
				->select('students.id', 'students.codigo', 'students.nome', 'courses.nome as turma')
				->when($filtro, function ($query, $filtro) {
					return $query->where(function ($q) use ($filtro) {
						$q->where('students.codigo', 'LIKE', "%$filtro%")
							->orWhere('students.nome', 'LIKE', "%$filtro%")
							->orWhere('courses.nome', 'LIKE', "%$filtro%");
					});
				})
				->when($cacifo, function ($query, $cacifo) {
					return $query->where(function ($q) use ($cacifo) {
						$q->whereNull('students.locker_id')
							->orWhere('students.locker_id', $cacifo);
					});
				})
				->get();
			return response()->json($alunos);
		} catch (\Exception $e) {
			return response()->json(null, 500);
		}
	}

	public function getAllStates()
	{
		try {
			$estados = State::select('states.id', 'states.nome')
				->orderBy('states.id', 'asc')
				->get();
			return response()->json($estados);
		} catch (\Exception $e) {
			return response()->json(null, 500);
		}
	}

	public function getAllAreas()
	{
		try {
			$locais = Area::select('areas.id', 'areas.nome')
				->orderBy('areas.nome', 'asc')
				->get();
			return response()->json($locais);
		} catch (\Exception $e) {
			return response()->json(null, 500);
		}
	}

	public function getAllTypologies()
	{
		try {
			$topologias = Typology::select('typologies.id', 'typologies.nome')
				->orderBy('typologies.nome', 'asc')
				->get();
			return response()->json($topologias);
		} catch (\Exception $e) {
			return response()->json(null, 500);
		}
	}

	public function updateStudents(Request $request, $id)
	{
		try {
			$attr = [];
			foreach ($request->selected as $aluno) {
				if (!empty($aluno['id'])) {
					$attr[] = $aluno['id'];
				}
			}

			DB::table('students')
				->where('locker_id', $id)
				->update(['locker_id' => null]);

			DB::table('students')
				->whereIn('id', $attr)
				->update(['locker_id' => $id]);

			DB::table('lockers')
				->where('id', $id)
				->update(['state_id' => DB::raw('(select count(*) from students where locker_id=' . $id . ') + 1')]);

			GridHelper::logger("CACI", "UPDT", Auth::user()->id, $id, !empty($attr[0]) ? $attr[0] : 0, !empty($attr[1]) ? $attr[1] : 0);
			
			return response()->json(202);
		} catch (\Exception $e) {
			return response()->json(null, 500);
		}
	}
}
