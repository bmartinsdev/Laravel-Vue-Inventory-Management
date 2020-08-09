<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locker extends Model
{
    public function area() 
    {
        return $this->belongsTo(Area::class);
    }

    public function state() 
    {
        return $this->belongsTo(State::class);
    }

    public function typology() 
    {
        return $this->belongsTo(Typology::class);
    }

    public function students(){
        return $this->hasMany(Student::class); 
    }
}
