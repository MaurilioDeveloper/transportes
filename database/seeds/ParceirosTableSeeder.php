<?php

use Illuminate\Database\Seeder;

class ParceirosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Parceiro::class, 5)->states('pessoa_fisica')->create();
        factory(\App\Parceiro::class, 5)->states('pessoa_juridica')->create();
    }
}
