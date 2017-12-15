<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHocSinhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoc_sinh', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mhs');
            $table->string('ho_ten_dem');
            $table->string('ten');
            $table->integer('id_lop');
            $table->string('que_quan')->nullable();
            $table->date('sinh_nhat')->nullable();
            $table->integer('sdt')->nullable();
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
        Schema::dropIfExists('hoc_sinh');
    }
}
