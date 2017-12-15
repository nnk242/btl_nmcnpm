<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mon', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mon');
            $table->string('ma_mon');
            $table->timestamps();
        });

        $mon = array('Toán học', 'Ngữ văn', 'Sinh học', 'Vật lý', 'Hóa học', 'Lịch sử', 'Ngoại ngữ', 'Giáo dục công dân', 'Giáo dục quốc phòng - an ninh', 'Thể dục', 'Công nghệ', 'Tin học');
        $ma_mon = array('th0', 'nv', 'sh', 'vl', 'hh', 'ls', 'dl', 'nn', 'gdcd', 'gdqpan', 'td', 'cn', 'th1');
        foreach ($mon as  $key=>$value) {
            DB::table('mon')->insert([
                'mon' => $value,
                'ma_mon' => $ma_mon[$key]
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mon');
    }
}
