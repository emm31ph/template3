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
            // ], [
            //     'name' => 'role-create',
            //     'display_name' => 'Create Roles', // optional
            //     'description' => 'create new roles', // optional
            // ], [
            //     'name' => 'role-update',
            //     'display_name' => 'Edit Roles', // optional
            //     'description' => 'Edit roles', // optional
            // ], [
            //     'name' => 'role-read',
            //     'display_name' => 'View Roles', // optional
            //     'description' => 'View roles', // optional
        ], [
            'name' => 'items-read',
            'display_name' => 'View Items', // optional
            'description' => 'View items', // optional
        ], [
            'name' => 'items-delivery',
            'display_name' => 'Delivery', // optional
            'description' => 'Delivery', // optional
        ], [
            'name' => 'items-delivery-update',
            'display_name' => 'Delivery Update', // optional
            'description' => 'Delivery Update', // optional
        ], [
            'name' => 'items-delivery-cancel',
            'display_name' => 'Delivery Cancel', // optional
            'description' => 'Delivery Cancel', // optional
        ], [
            'name' => 'items-fptd',
            'display_name' => 'FPTD', // optional
            'description' => 'FPTD', // optional
        ],  [
            'name' => 'items-fptd-update',
            'display_name' => 'FPTD Update', // optional
            'description' => 'FPTD Update', // optional
        ], [
            'name' => 'items-fptd-cancel',
            'display_name' => 'FPTD Cancel', // optional
            'description' => 'FPTD Cancel', // optional
        ],[
            'name' => 'items-rr',
            'display_name' => 'Recieving Report', // optional
            'description' => 'Recieving Report', // optional
        ],  [
            'name' => 'items-rr-update',
            'display_name' => 'Recieving Report Update', // optional
            'description' => 'Recieving Report Update', // optional
        ], [
            'name' => 'items-rr-cancel',
            'display_name' => 'Recieving Report Cancel', // optional
            'description' => 'Recieving Report Cancel', // optional
        ],[
            'name' => 'items-rrm',
            'display_name' => 'RRM', // optional
            'description' => 'RRM', // optional
        ],  [
            'name' => 'items-rrm-update',
            'display_name' => 'RRM Update', // optional
            'description' => 'RRM Update', // optional
        ], [
            'name' => 'items-rrm-cancel',
            'display_name' => 'RRM Cancel', // optional
            'description' => 'RRM Cancel', // optional
        ],[
            'name' => 'items-reject',
            'display_name' => 'Reject', // optional
            'description' => 'Reject', // optional
        ], [
            'name' => 'items-reject-update',
            'display_name' => 'Reject Update', // optional
            'description' => 'Reject Update', // optional
        ], [
            'name' => 'items-reject-cancel',
            'display_name' => 'Reject Cancel', // optional
            'description' => 'Reject Cancel', // optional
        ], [
            'name' => 'items-import',
            'display_name' => 'import', // optional
            'description' => 'import', // optional
        ], [
            'name' => 'items-adjust',
            'display_name' => 'Items Adjustment', // optional
            'description' => 'Items Adjustment', // optional
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
            'name' => 'products-cancel',
            'display_name' => 'Product Cancel', // optional
            'description' => 'Product Cancel', // optional
        ]
    
        , [
            'name' => 'price-cat-create',
            'display_name' => 'Price Category Create New', // optional
            'description' => 'Price Category Create New', // optional
        ], [
            'name' => 'price-cat-read',
            'display_name' => 'Price Category read', // optional
            'description' => 'Price Category read', // optional
        ], [
            'name' => 'price-cat-update',
            'display_name' => 'Price Category update', // optional
            'description' => 'Price Category update', // optional
        ], [
            'name' => 'price-cat-cancel',
            'display_name' => 'Price Category Cancel', // optional
            'description' => 'Price Category Cancel', // optional
        ], [
            'name' => 'price-cat-copy',
            'display_name' => 'Price Category Copy from EBT', // optional
            'description' => 'Price Category Copy from EBT', // optional
        ]
        , [
            'name' => 'price-cust-create',
            'display_name' => 'Price Customer Create New', // optional
            'description' => 'Price Customer Create New', // optional
        ], [
            'name' => 'price-cust-read',
            'display_name' => 'Price Customer read', // optional
            'description' => 'Price Customer read', // optional
        ], [
            'name' => 'price-cust-update',
            'display_name' => 'Price Customer update', // optional
            'description' => 'Price Customer update', // optional
        ], [
            'name' => 'price-cust-cancel',
            'display_name' => 'Price Customer Cancel', // optional
            'description' => 'Price Customer Cancel', // optional
        ]
        , [
            'name' => 'price-list-create',
            'display_name' => 'Price List Create New', // optional
            'description' => 'Price List Create New', // optional
        ], [
            'name' => 'price-list-read',
            'display_name' => 'Price List read', // optional
            'description' => 'Price List read', // optional
        ], [
            'name' => 'price-list-update',
            'display_name' => 'Price List update', // optional
            'description' => 'Price List update', // optional
        ], [
            'name' => 'price-list-cancel',
            'display_name' => 'Price List Cancel', // optional
            'description' => 'Price List Cancel', // optional
        ], [
            'name' => 'transaction-cancel',
            'display_name' => 'Transaction Cancel', // optional
            'description' => 'Transaction Cancel', // optional
        ]];

        Permission::insert($data);

    }
}
