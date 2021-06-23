<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Role::create([
            'name' => 'warehouse',
            'display_name' => 'Warehouse', // optional
            'description' => 'Warehouse access contro list', // optional
        ]);

        $user = \App\Models\User::create([
            'name' => 'Raymond Tabor',
            'username' => 'r.tabor',
            'email' => 'r.tabor@app.com',
            'status' => '01',
            'branch' => 'MAIN',
            'password' => bcrypt('password'),
        ]);
        $user = \App\Models\User::create([
            'name' => 'Martin Barabona',
            'username' => 'm.barabona',
            'email' => 'm.barabona@app.com',
            'status' => '01',
            'branch' => 'ILO',
            'password' => bcrypt('password'),
        ]);

        $user = \App\Models\User::create([
            'name' => 'Stephanie Santiago',
            'username' => 's.santiago',
            'email' => 's.santiago@app.com',
            'status' => '01',
            'branch' => 'ILO',
            'password' => bcrypt('password'),
        ]);

        $user = \App\Models\User::create([
            'name' => 'Christian Jay Loyd Suing',
            'username' => 'cj.suing',
            'email' => 'cj.suing@app.com',
            'status' => '01',
            'branch' => 'CEB',
            'password' => bcrypt('password'),
        ]);

    }
}
