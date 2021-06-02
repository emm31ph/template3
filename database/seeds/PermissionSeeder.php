<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [[
            'name' => 'role-create',
            'display_name' => 'Create Roles', // optional
            'description' => 'create new roles', // optional
        ], [
            'name' => 'role-update',
            'display_name' => 'Edit Roles', // optional
            'description' => 'Edit roles', // optional
        ], [
            'name' => 'role-read',
            'display_name' => 'View Roles', // optional
            'description' => 'View roles', // optional
        ], [
            'name' => 'items-read',
            'display_name' => 'View Items', // optional
            'description' => 'View items', // optional
        ], [
            'name' => 'items-delivery',
            'display_name' => 'Delivery', // optional
            'description' => 'Delivery', // optional
        ], [
            'name' => 'items-fptd',
            'display_name' => 'FPTD', // optional
            'description' => 'FPTD', // optional
        ], [
            'name' => 'items-rr',
            'display_name' => 'Recieving Report', // optional
            'description' => 'Recieving Report', // optional
        ], [
            'name' => 'items-rrm',
            'display_name' => 'RRM', // optional
            'description' => 'RRM', // optional
        ], [
            'name' => 'items-reject',
            'display_name' => 'Reject', // optional
            'description' => 'Reject', // optional
        ], [
            'name' => 'item-import',
            'display_name' => 'Import', // optional
            'description' => 'Import', // optional
        ]];

        Permission::insert($data);

    }
}
