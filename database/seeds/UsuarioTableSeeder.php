<?php

use Illuminate\Database\Seeder;

class UsuarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(array(
            array('name'=>'Administrador','email'=>'admin@gmail.com','password'=>bcrypt('123456')),
            array('name'=>'Maurilio Silva','email'=>'mauriliodeveloper@gmail.com','password'=>bcrypt('mamama')),
        ));
    }
}
