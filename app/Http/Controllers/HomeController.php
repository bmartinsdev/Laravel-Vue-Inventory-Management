<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GridHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
	public function index()
	{
		return view('vueloader');
	}

	public function vuerouter()
	{
		return view('vueloader');
	}

	public function perfil()
	{
		return view('settings.perfil');
	}

	public function creditos()
	{
		return view('credits');
	}

	public function editarPerfil(Request $request)
	{
		return redirect(url('creditos'))->with('warning','Versão demo');
		$user = Auth::user();
		$request->validate([
			'name' => 'required|string|max:255',
			'password' => 'nullable|min:8|string|confirmed',
			'password_antiga' => ['required', function ($attribute, $value, $fail) {
				if (!\Hash::check($value, Auth::user()->password)) {
						return $fail(__('A password inserida não corresponde à password atual.'));
				}
		}],
		]);

		$user->name = $request->name;
		if($request->password != "") {
			$user->password = Hash::make($request->password);
		}
		$user->save();
		return redirect(url('/'))->with('success','Perfil alterado com sucesso.');
	}

	public function apagarPerfil()
	{
		return redirect(url('creditos'))->with('warning','Versão demo');
		$user = Auth::user();
		Auth::logout();
		if ($user->delete()) {
			return Redirect::route('login');
		}
	}
}
