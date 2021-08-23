<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => true,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'administrator' => [
            'users' => 'c,r,u,d,nt',
            'role' => 'c,u,r',
            'profile' => 'r,u',
            'items' => 'r,a,im,itr,itd,itdu,itf,itfu,itrr,itrru,itrm,itrmu,itrj,itrju',
            'products' => 'c,r,u,cn,g',
            // 'products' => 'c,r,u,cn',
            'price cat' => 'c,r,u,cn,g',
            'price cust' => 'c,r,u,cn,g',
            'price list' => 'c,r,u,cn',
            'transaction' => 'tx',
            'invoice' => 'c,r,u,cn',
            'sales person' => 'c,r,u,d',
            'shipping advice' => 'c,r,u,ap',
            'packing list' => 'c,r,u,ap',
            'signatory' => 'r,u',

        ],
        'user' => [
            'profile' => 'r,u',
        ],
        'warehouse' => [
            'items' => 'r,a,im,itr,itd,itdu,itf,itfu,itrr,itrru,itrm,itrmu,itrj,itrju',
        ],
        'sales' => [
            'invoice' => 'c,r,u,cn',
        ],
        'shipping' => [
            'shipping advice' => 'c,r',
            'packing list' => 'c,r',
        ],
        'packing' => [
            'packing list' => 'c,r',
        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'g' => 'generate',
        'cn' => 'cancel',
        'rm' => 'remove',
        'r' => 'read',
        'a' => 'adjust',
        'u' => 'update',
        'd' => 'delete',
        'nt' => 'notify',
        'im' => 'import',
        'itr' => 'View',
        'itd' => 'Delivery',
        'itdu' => 'Delivery Update',
        #'itdc' => 'Delivery Cancel',
        'itf' => 'FPTD',
        'itfu' => 'FPTD Update',
        #'itfc' => 'FPTD Cancel',
        'itrr' => 'RR',
        'itrru' => 'RR Update',
        #'itrrc' => 'RR Cancel',
        'itrm' => 'RRM',
        'itrmu' => 'RRM Update',
        #'itrmc' => 'RRM Cancel',
        'itrj' => 'Reject',
        'itrju' => 'Reject Update',
        #'itrjc' => 'Reject Cancel',
        'tx' => 'Cancel',
        'cf' => 'Copy From',
        'ap' => 'Approve',

    ],
];
