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
            'name' => 'users-notify',
            'display_name' => 'Notification', // optional
            'description' => 'Alert user', // optional
        ], [
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
            'name' => 'products-create',
            'display_name' => 'Product Create New', // optional
            'description' => 'Product Create New', // optional
        ], [
            'name' => 'products-read',
            'display_name' => 'Product read', // optional
            'description' => 'Product read', // optional
        ], [
            'name' => 'products-update',
            'display_name' => 'Product update', // optional
            'description' => 'Product update', // optional
        ], [
            'name' => 'products-delete',
            'display_name' => 'Product delete', // optional
            'description' => 'Product delete', // optional
        ]];

        Permission::insert($data);

    }
}
