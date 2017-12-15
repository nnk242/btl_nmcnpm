<?php

use Illuminate\Database\Seeder;
use App\Subject;

class ResultTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $subjects = Subject::all();


        for($i=0; $i<200; $i++) {
            $lop = rand(1, 3);
            for($k = 0; $k<$lop; $k++) {
                if ($k==0) {
                    $l = 1;
                }elseif ($k==1) {
                    $l = 2;
                } else {
                    $l = 3;
                }
                foreach ($subjects as $subject) {
                    $diem_1 = rand(3,10);
                    $diem_2 = rand(3,10);
                    $diem_3 = rand(3,10);
                    $diem_giua_ky = rand(3,10);
                    $diem_cuoi_ky = rand(3,10);
                    $dtb = round((($diem_3 + $diem_2 + $diem_1 + $diem_giua_ky*2 + $diem_cuoi_ky*3)/80), 2)*10;

                    DB::table('ket_qua_hoc_tap_ky_1')->insert([
                        'id_sv' => $i+1,
                        'id_lop' => $l,
                        'id_gv' => $subject->id,
                        'mon' => $subject->id,
                        'diem_1' => $diem_1,
                        'diem_2' => $diem_2,
                        'diem_3' => $diem_3,
                        'diem_giua_ky' => $diem_giua_ky,
                        'diem_cuoi_ky' => $diem_cuoi_ky,
                        'diem_trung_binh' => $dtb
                    ]);
                }
                foreach ($subjects as $subject) {
                    $diem_1 = rand(3,10);
                    $diem_2 = rand(3,10);
                    $diem_3 = rand(3,10);
                    $diem_giua_ky = rand(3,10);
                    $diem_cuoi_ky = rand(3,10);
                    $dtb = round((($diem_3 + $diem_2 + $diem_1 + $diem_giua_ky*2 + $diem_cuoi_ky*3)/80), 2)*10;

                    DB::table('ket_qua_hoc_tap_ky_2')->insert([
                        'id_sv' => $i+1,
                        'id_lop' => $l,
                        'id_gv' => $subject->id,
                        'mon' => $subject->id,
                        'diem_1' => $diem_1,
                        'diem_2' => $diem_2,
                        'diem_3' => $diem_3,
                        'diem_giua_ky' => $diem_giua_ky,
                        'diem_cuoi_ky' => $diem_cuoi_ky,
                        'diem_trung_binh' => $dtb
                    ]);
                }
            }
        }
    }
}
