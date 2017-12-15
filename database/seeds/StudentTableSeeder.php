<?php

use Illuminate\Database\Seeder;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ho_ten_dem = ['Nguyễn Văn', 'Nguyễn Ngọc', 'Nguyễn Anh', 'Nguyễn Hưng', 'Trần Đình', 'Vũ Văn'];
        $ten = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'W', 'X', 'V'. 'Z', 'J', 'S', 'R', 'Y'];

        $count_ho_ten_dem = count($ho_ten_dem) - 1;
        $count_ten = count($ten) - 1;

        for($i=1; $i<=200; $i++) {
            $rand_ho_ten_dem = rand(0, $count_ho_ten_dem);
            $rand_ten = rand(0, $count_ten);

            $date_1 = strtotime('1997-01-01');
            $date_2 = strtotime('2003-12-31');
            $day_random = rand($date_1, $date_2);
            $day = date("Y-m-d", $day_random);

            $id_lop = rand(1, 15);
            $strlen_i = strlen($i);
            if ($strlen_i == 0) {
                $k= '0000';
            } elseif ($strlen_i == 1) {
                $k = '000' . $i;
            } elseif ($strlen_i == 2) {
                $k = '00' .$i;
            } elseif ($strlen_i == 3) {
                $k = '0' . $i;
            } elseif ($strlen_i == 4) {
                $k = $i;
            }
            $mhs = $k . $id_lop;
            $pass = $mhs . str_replace('-', '', $day);

            DB::table('hoc_sinh')->insert([
                'ho_ten_dem' => $ho_ten_dem[$rand_ho_ten_dem],
                'ten' => $ten[$rand_ten],
                'id_lop' => $id_lop,
                'sinh_nhat' => $day,
                'mhs' => $mhs
            ]);

            DB::table('users')->insert([
                'name' => $ten[$rand_ten],
                'username' => $mhs,
                'password' => bcrypt($pass),
                'role' => 3
            ]);
        }
    }
}
