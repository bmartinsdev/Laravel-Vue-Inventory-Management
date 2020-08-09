<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public function lockers(){
        return $this->hasMany(Locker::class); 
    }
}
