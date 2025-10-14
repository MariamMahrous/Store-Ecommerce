<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Admin::create([
        'name'=>'mariam mahrous',
        'email'=>'admin@gmail.com',
        'password'=>bcrypt('123456789'),
       ]);


    }
}
