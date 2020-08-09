<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Inventory;
use App\Room;

class Unit extends Model
{
	use SoftDeletes;
	public function inventories()
	{
		return $this->belongsTo(Inventory::class);
	}

	public function rooms()
	{
		return $this->belongsTo(Room::class);
	}
}
