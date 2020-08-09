<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
	protected $fillable = ['codigo', 'nome', 'course_id'];
	public function lockers()
	{
		return $this->belongsTo(Locker::class);
	}

	public function courses()
	{
		return $this->belongsTo(Course::class);
	}
}
