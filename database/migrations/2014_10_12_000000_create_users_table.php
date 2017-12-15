<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('username', 30)->unique();
            $table->string('password');
            $table->string('image')->nullable();
            $table->string('que_quan')->nullable();
            $table->date('sinh_nhat')->nullable();
            $table->integer('sdt')->nullable();
            $table->integer('role');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([[
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('btl123'),
            'role' => 1
        ],
            [
                'name' => 'Giáo viên',
                'username' => 'giao_vien',
                'email' => 'teacher@example.com',
                'password' => bcrypt('teacher123'),
                'role' => 2
            ],[
            'name' => 'Học sinh',
            'username' => 'hoc_sinh',
            'email' => 'student@example.com',
            'password' => bcrypt('student123'),
            'role' => 3
        ]]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
