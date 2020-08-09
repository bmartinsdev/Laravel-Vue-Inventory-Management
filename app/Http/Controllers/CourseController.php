<?php

namespace App\Http\Controllers;

use App\Course;
use App\GridHelper;
use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CourseController extends Controller
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
		$courses = Course::select('courses.id', 'courses.nome')
			->when($filtro, function ($query, $filtro) {
				return $query->where('courses.nome', 'LIKE', "%$filtro%");
			})
			->when($order, function ($query, $order) {
				switch ($order) {
					case 'nome':
						return $query->orderBy('courses.nome');
					case 'id':
						return $query->orderBy('courses.id', 'DESC');
				}
			}, function ($query) {
				return $query->orderBy('courses.id', 'DESC');
			})
			->paginate(10);
		return view('settings.c.course.index')->with(compact('courses'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('settings.c.course.create');
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
			'nome' => 'required|string|max:255|unique:courses,nome',
		]);
		$course = new Course();
		$course->nome = $request->nome;
		$course->save();
		GridHelper::setOption("turmas", Course::count(), "count");
		return redirect('/definicoes/c/turmas/' . $course->id . '/edit')->with('success','Adicionado com sucesso.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Course  $course
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return redirect('/definicoes/c/turmas/' . $id . '/edit');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Course  $course
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$course = Course::find($id);
		return view('settings.c.course.edit')->with(compact('course'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Course  $course
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$request->validate([
			'nome' => 'required|string|max:255|unique:courses,nome,' . $id,
			'formandos' => 'file|max:30000'
		]);

		$course = Course::find($id);
		$course->nome = $request->nome;
		$course->save();
		if($request->hasFile('formandos')) {
			try{
				Excel::import(new StudentsImport($id), request()->file('formandos'));
			} catch (\Exception $e) {
				return back()->withError($e->getMessage())->withInput();
			}
			return redirect('/definicoes/c/formandos?turma=' . $course->nome)->with('success','Formandos adicionados com sucesso.');
		}
		return redirect('/definicoes/c/turmas')->with('success','Editado com sucesso.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Course  $course
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		Course::destroy($id);
		GridHelper::setOption("turmas", Course::count(), "count");
		return redirect('/definicoes/c/turmas')->with('success','Apagado com sucesso.');
	}
}
