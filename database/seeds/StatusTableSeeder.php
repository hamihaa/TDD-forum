<?php

use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('thread_status')->insert([
            ['status_name' => 'Nepotrjeno'],
            ['status_name' => 'V razpravi'],
            ['status_name' => 'V glasovanju'],
            ['status_name' => 'Posredovano pristojnemu organu'],
            ['status_name' => 'Predlog sprejet'],
            ['status_name' => 'Predlog zavrnjen'],
            ['status_name' => 'Neustrezno']
        ]);
    }
}
