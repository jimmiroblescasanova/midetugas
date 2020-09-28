<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'          => 'Jimmi Robles',
            'email'         => 'jimmirobles@icloud.com',
            'password'      => Hash::make('password'),
            'admin'         => true,
            'created_at'    => \Carbon\Carbon::now(),
        ]);
    }
}
