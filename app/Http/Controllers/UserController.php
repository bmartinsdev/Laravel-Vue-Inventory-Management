<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$nome = $request->nome;
		$email = $request->email;
		$perms = $request->perms;
		$order = $request->order;
		$users = User::select('users.id', 'users.name', 'users.email', 'users.perms')
			->when($nome, function ($query, $nome) {
				return $query->where('users.name', 'LIKE', "%$nome%");
			})
			->when($email, function ($query, $email) {
				return $query->where('users.email', 'LIKE', "%$email%");
			})
			->when($perms, function ($query, $perms) {
				return $query->where('users.perms', $perms);
			})
			->when($order, function ($query, $order) {
				switch ($order) {
					case 'nome':
						return $query->orderBy('users.name');
					case 'email':
						return $query->orderBy('users.email');
					case 'id':
						return $query->orderBy('users.id', 'DESC');
				}
			}, function ($query) {
				return $query->orderBy('users.id', 'DESC');
			})
			->paginate(10);
		return view('settings.users.index')->with(compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$users = User::all();
		return view('settings.users.create')->with(compact('users'));
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
			'name' => 'required|string|max:255',
			'email' => 'required|string|unique:users,email',
			'password' => 'required|min:8|string|confirmed',
			'perms' => 'required|int',
		]);
		$user = new User();
		$user->name = $request->name;
		$user->email = $request->email;
		$user->password = Hash::make($request->password);
		$user->perms = $request->perms;
		$user->save();
		
		return redirect('/definicoes/utilizadores')->with('success','Adicionado com sucesso.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return redirect('/definicoes/utilizadores/' . $id . '/edit');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if ($id == Auth::user()->id) {
			return redirect('/definicoes/utilizadores');
		}
		$user = User::find($id);
		return view('settings.users.edit')
			->with(compact('user'));
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
		return view('credits');
		$request->validate([
			'name' => 'required|string|max:255',
			'email' => 'required|string|unique:users,email,' . $id,
			'password' => 'nullable|required_with:password_confirmation|min:8|string|confirmed',
			'perms' => 'required|int',
		]);
		$user = User::find($id);
		$user->name = $request->name;
		$user->email = $request->email;
		if ($request->password) {
			$user->password = Hash::make($request->password);
		}
		$user->perms = $request->perms;
		$user->save();
		return redirect('/definicoes/utilizadores')->with('success','Editado com sucesso.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		return redirect(url('creditos'))->with('warning','Versão demo');
		if ($id == Auth::user()->id) {
			return redirect('/definicoes/utilizadores')->with('warning','Operação cancelada.');
		}
		User::destroy($id);
		
		return redirect('/definicoes/utilizadores')->with('success','Apagado com sucesso.');
	}
}
