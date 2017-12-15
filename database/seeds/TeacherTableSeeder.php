<?php

use Illuminate\Database\Seeder;

class TeacherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $giao_vien = 'Giáo viên';
        for ($i = 1; $i<=12; $i++) {
            DB::table('giao_vien')->insert([
                'ho_ten_dem' => $giao_vien,
                'ten' => $i,
                'id_mon' => $i,
                'id_gv' => usernameTeacher($giao_vien . ' ' . $i)
            ]);
            DB::table('users')->insert([
                'name' => $i,
                'username' => usernameTeacher($giao_vien . ' ' . $i),
                'password' => bcrypt(usernameTeacher($giao_vien . ' ' . $i)),
                'role' => 2
            ]);
        }
    }
}
