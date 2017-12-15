<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKetQuaHocTapKy2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ket_qua_hoc_tap_ky_2', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_sv');
            $table->integer('id_gv');
            $table->string('mon', 30);
            $table->float('diem_1')->nullable();
            $table->float('diem_2')->nullable();
            $table->float('diem_3')->nullable();
            $table->float('diem_giua_ky')->nullable();
            $table->float('diem_cuoi_ky')->nullable();
            $table->float('diem_trung_binh')->nullable();
            $table->integer('id_lop');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ket_qua_hoc_tap_ky_2');
    }
}
