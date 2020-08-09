<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GlobalVariable extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'option_name', 'option_value', 'option_type'
	];
}
