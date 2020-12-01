<?php

return [
    'roles_structure' => [
        'super_admin' => [
            'users' => 'c,r,u,d',
            'crops' => 'c,r,u,d',
            'delegates' => 'c,r,u,d',
            'offices' => 'c,r,u,d',
            'state' => 'c,r,u,d',
            'towns' => 'c,r,u,d',
            'zones' => 'c,r,u,d',
            'receipts' => 'c,r,u,d',
        ],
        'admin' => []
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
