<?php

namespace App\Http\Controllers;

use App\Student;
use App\Course;
use App\GridHelper;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $nome = $request->nome;
        $codigo = $request->codigo;
        $turma = $request->turma;
        $order = $request->order;
        $courses = Course::orderBy('nome','asc')->get();
        
        $students = Student::leftJoin('courses', 'students.course_id', '=', 'courses.id')
            ->select('students.id', 'students.nome', 'students.codigo', 'courses.nome as turma')
            ->when($nome, function ($query, $nome) {
                return $query->where('students.nome', 'LIKE', "%$nome%");
            })
            ->when($codigo, function ($query, $codigo) {
                return $query->where('students.codigo', 'LIKE', "%$codigo%");
            })
            ->when($turma, function ($query, $turma) {
                return $query->where('courses.nome', 'LIKE', "%$turma%");
            })
            ->when($order, function ($query, $order) {
                switch ($order) {
                    case 'nome':
                        return $query->orderBy('students.nome');
                    case 'codigo':
                        return $query->orderBy('students.codigo', 'asc');
                    case 'turma':
                        return $query->orderBy('courses.nome', 'asc');
                }
            }, function ($query) {
                return $query->orderBy('students.codigo', 'DESC');
            })
            ->paginate(10);

        return view('settings.c.students.index')
            ->with(compact('students'))
            ->with(compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::all();
        return view('settings.c.students.create')
            ->with(compact('courses'));
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
            'nome' => 'required|string|max:255',
            'codigo' => 'string|required|unique:students,codigo',
            'course' => 'numeric|required',
        ]);
        $student = new Student();
        $student->nome = $request->nome;
        $student->codigo = $request->codigo;
        $student->course_id = $request->course;
        $student->save();
        GridHelper::setOption("formandos", Student::count(), "count");
        return redirect('/definicoes/c/formandos')->with('success','Adicionado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('/definicoes/c/formandos/' . $id . '/edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $courses = Course::orderBy('nome','asc')->get();
        $student = Student::find($id);
        return view('settings.c.students.edit')
            ->with(compact('student'))
            ->with(compact('courses'));
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
            'nome' => 'required|string|max:255',
            'course' => 'required|not_in:0',
        ]);
        $student = Student::find($id);
        $student->nome = $request->nome;
        $student->course_id = $request->course;
        $student->save();
        GridHelper::setOption("formandos", Student::count(), "count");
        return redirect('/definicoes/c/formandos')->with('success','Editado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Student::destroy($id);
        GridHelper::setOption("formandos", Student::count(), "count");
        return redirect('/definicoes/c/formandos')->with('success','Apagado com sucesso.');
    }
}
