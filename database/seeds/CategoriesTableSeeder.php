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
            ['name' => 'davki_finance',
            'slug' => 'davki_finance'],

            ['name' => 'gospodarstvo',
            'slug' => 'gospodarstvo'],

            ['name' => 'javna_uprava',
            'slug' => 'javna_uprava'],

            ['name' => 'kultura',
            'slug' => 'kultura'],

            ['name' => 'davki_finance',
            'slug' => 'davki_finance'],

            ['name' => 'kmetijstvo',
            'slug' => 'kmetijstvo'],

            ['name' => 'notranje',
            'slug' => 'notranje'],

            ['name' => 'obramba',
            'slug' => 'obramba'],

            ['name' => 'okolje',
            'slug' => 'okolje'],

            ['name' => 'pravosodje',
            'slug' => 'pravosodje'],

            ['name' => 'promet',
            'slug' => 'promet'],

            ['name' => 'sociala',
            'slug' => 'sociala'],

            ['name' => 'splosno',
            'slug' => 'splosno'],

            ['name' => 'solstvo',
            'slug' => 'solstvo'],

            ['name' => 'visoko_solstvo_znanost',
            'slug' => 'visoko_solstvo_znanost'],

            ['name' => 'zdravje',
            'slug' => 'zdravje'],

            ['name' => 'zunanje',
            'slug' => 'zunanje']

        ]);
    }
}
