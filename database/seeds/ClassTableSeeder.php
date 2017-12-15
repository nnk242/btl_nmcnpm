<?php

use Illuminate\Database\Seeder;

class ClassTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i=1; $i<6; $i++) {
            for($k=10;$k<=12;$k++) {
                DB::table('lop')->insert([
                    'lop' => $k,
                    'khoa' => $i,
                ]);
            }
        }
    }
}
