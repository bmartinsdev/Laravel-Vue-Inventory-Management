<?php

namespace App\Imports;

use App\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class StudentsImport implements ToModel, SkipsOnError
{ 
	use Importable, SkipsErrors;
	public function __construct($id)
	{
		$this->id = $id;
	}
	/**
	 * @param array $row
	 *
	 * @return \Illuminate\Database\Eloquent\Model|null
	 */
	public function model(array $row)
	{
		return new Student([
			'codigo' => $row[0],
			'nome' => $row[1],
			'course_id' => $this->id,
		]);
	}
}
