<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function units(){
        return $this->hasMany(Unit::class); 
		}
}
