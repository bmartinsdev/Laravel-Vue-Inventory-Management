<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Typology extends Model
{
    public function lockers(){
        return $this->hasMany(Locker::class); 
    }
}
