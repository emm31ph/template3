<?php

use App\Models\User;
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

        
        $user = \App\Models\User::create([
            'name' => 'Edmund Managuit',
            'username' => 'e.managuit',
            'email' => 'e.managuit@app.com',
            'status' => '01',
            'branch' => 'MAIN',
            'usertype' => 'U001',
            'password' => bcrypt('password'),
        ]);

          $user->syncRoles([2, 3]);
        $user->syncBranch()->sync(['MAIN', "CEB", "ILO"]); 

        $user = \App\Models\User::create([
            'name' => 'Martin Barabona',
            'username' => 'm.barabona',
            'email' => 'm.barabona@app.com',
            'status' => '01',
            'branch' => 'ILO',
            'usertype' => 'U001',
            'password' => bcrypt('password'),
        ]);
        $user->syncRoles([2, 3]);
        $user->syncBranch()->sync(["ILO"]);

        $user = \App\Models\User::create([
            'name' => 'Stephanie Santiago',
            'username' => 's.santiago',
            'email' => 's.santiago@app.com',
            'status' => '01',
            'branch' => 'ILO',
            'usertype' => 'U001',
            'password' => bcrypt('password'),
        ]);
        $user->syncRoles([2, 3]);
        $user->syncBranch()->sync(["ILO"]);

        $user = \App\Models\User::create([
            'name' => 'Christian Jay Loyd Suing',
            'username' => 'cj.suing',
            'email' => 'cj.suing@app.com',
            'status' => '01',
            'branch' => 'CEB',
            'usertype' => 'U001',
            'password' => bcrypt('password'),
        ]);
        $user->syncRoles([2, 3]);
        $user->syncBranch()->sync(["CEB"]);  

        
        $user = \App\Models\User::create([
            'name' => 'Kreus Pagulayan',
            'email' => 'k.pagulayan@app.com',
            'status' => '01',
            'username' => 'k.pagulayan',
            'branch' => 'MAIN',
            'usertype' => 'U001',
            'password' => bcrypt('password'),
        ]);

        $user->syncRoles([2, 5]);
        $user->syncBranch()->sync(['MAIN']);

        $user = \App\Models\User::create([
            'name' => 'Rachel Matias',
            'email' => 'r.matias@app.com',
            'status' => '01',
            'username' => 'r.matias',
            'branch' => 'MAIN',
            'usertype' => 'U001',
            'password' => bcrypt('password'),
        ]);

        $user->syncRoles([2, 6]);
        $user->syncBranch()->sync(['MAIN']);

        
         $user = \App\Models\User::create([
            'name' => 'Rolando Santos Jr.',
            'email' => 'r.santos@app.com',
            'status' => '01',
            'username' => 'r.santos',
            'branch' => 'MAIN',
            'usertype' => 'U001',
            'password' => bcrypt('password'),
        ]);

        $user->syncRoles([2, 3]);
        $user->syncBranch()->sync(['MAIN']);


        $datas = DB::connection('mysql2')->select("select userid as username,username as `name`, ISVALID from users where GROUPID='SALES' and ISVALID='1'");

        $chucks = array_chunk($datas, 500);
        foreach ($chucks as $chuck) {
            foreach ($chuck as $data) {
                $item =
                    [
                    'username' => $data->username,
                    'name' => $data->name,
                    'email' => strtolower(str_replace(' ', '_', $data->name)) . '@app.com',
                    'password' => bcrypt('password'),
                    'usertype' => 'U002',
                ]
                ;
                // DB::table('users')->insert($item);
                $user = User::create($item);
                $user->syncRoles([4]);
                $user->syncBranch()->sync(["MAIN"]);

                DB::select('UPDATE sales_persons sp INNER JOIN users u on sp.salespersonname=u.name SET sp.user_id = u.id');
            }
        }
    }
}