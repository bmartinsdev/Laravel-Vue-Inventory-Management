<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GridHelper;

class AdminController extends Controller
{
    
		
	public function estatisticas()
	{
		return view('settings.estatisticas');
	}

	public function definicoes()
	{
		$counts = GridHelper::getAllCounts();
		return view('settings.settings')
			->with(compact('counts'));
	}
}
