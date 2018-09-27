<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'davki in finance',
                'slug' => 'davki_finance'
            ],

            [
                'name' => 'gospodarstvo',
                'slug' => 'gospodarstvo'
            ],

            [
                'name' => 'javna uprava',
                'slug' => 'javna_uprava'
            ],

            [
                'name' => 'kultura',
                'slug' => 'kultura'
            ],

            [
                'name' => 'davki in finance',
                'slug' => 'davki_finance'
            ],

            [
                'name' => 'kmetijstvo',
                'slug' => 'kmetijstvo'
            ],

            [
                'name' => 'notranje zadeve',
                'slug' => 'notranje'
            ],

            [
                'name' => 'obramba',
                'slug' => 'obramba'
            ],

            [
                'name' => 'okolje',
                'slug' => 'okolje'
            ],

            [
                'name' => 'pravosodje',
                'slug' => 'pravosodje'
            ],

            [
                'name' => 'promet',
                'slug' => 'promet'
            ],

            [
                'name' => 'sociala',
                'slug' => 'sociala'
            ],

            [
                'name' => 'splošno',
                'slug' => 'splosno'
            ],

            [
                'name' => 'šolstvo',
                'slug' => 'solstvo'
            ],

            [
                'name' => 'visoko šolstvo in znanost',
                'slug' => 'visoko_solstvo_znanost'
            ],

            [
                'name' => 'zdravje',
                'slug' => 'zdravje'
            ],

            [
                'name' => 'zunanje zadeve',
                'slug' => 'zunanje'
            ]

        ]);
    }
}
