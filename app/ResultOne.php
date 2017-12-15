<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResultOne extends Model
{
    //
    protected $table='ket_qua_hoc_tap_ky_1';

    public function Subject() {
        return $this->hasOne(Subject::class, 'id', 'mon');
    }

    public function Student() {
        return $this->hasOne(Student::class, 'id', 'id_sv');
    }
}
