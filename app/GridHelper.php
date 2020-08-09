<?php

namespace App;

use App\GlobalVariable;
use DateTime;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GridHelper
{

	public static function setOption($option, $value, $type)
	{
		GlobalVariable::updateOrCreate(
			['option_name' => $option],
			['option_value' => $value, 'option_type' => $type]
		);
	}

	public static function getAllCounts(){
		return GlobalVariable::where('option_type', 'count')->pluck('option_value', 'option_name');
	}

	public static function getOption($option)
	{
		return GlobalVariable::find($option)->pluck('option_value');
	}
	public static function logger($page, $action, $userid, $targetid, $old, $new){
		DB::table('gridlogs')->insert(
			[
				'page' => $page, 
				'action' => $action, 
				'user_id' => $userid,
				'target_id' => $targetid,
				'old_value' => $old,
				'new_value' => $new,
				'created_at' => Carbon::now() 
			]);
	}
}
