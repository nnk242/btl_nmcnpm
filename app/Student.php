<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $table='hoc_sinh';


    public function Lop() {
        return $this->hasOne(ClassS::class, 'id', 'id_lop');
    }

    public function ResultOne() {
        return $this->hasMany(ResultOne::class, 'id_sv', 'id');
    }

    public function ResultTwo() {
        return $this->hasMany(ResultTwo::class, 'id_sv', 'id');
    }

}
