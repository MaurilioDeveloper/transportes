<?php

use Illuminate\Database\Seeder;

class user extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(array(
            array('name'=>'Wilterson Garcia','email'=>'wiltersongarcia@gmail.com','password'=>bcrypt('123456')),
            array('name'=>'Jane Doe','email'=>'jane@gmail.com','password'=>bcrypt('123456')),
            array('name'=>'John Doe','email'=>'john@gmail.com','password'=>bcrypt('123456')),
            array('name'=>'Kevin Smith','email'=>'kevin@gmail.com','password'=>bcrypt('123456')),
            array('name'=>'Megan Smith','email'=>'megan@gmail.com','password'=>bcrypt('123456')),
            array('name'=>'Joshua Lewis','email'=>'joshua@gmail.com','password'=>bcrypt('123456')),
            array('name'=>'Jessica Lewis','email'=>'jessica@gmail.com','password'=>bcrypt('123456'))
        ));
    }
}
