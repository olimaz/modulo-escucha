<?php

return [

    'usernames' => [

        'ldap' => [

            // replace this line:
            // 'discover' => 'userprincipalname',
            // with this one:
            'discover' => env('LDAP_USER_ATTRIBUTE', 'userprincipalname'),

            // replace this line:
            // 'authenticate' => 'distinguishedname',
            // with this one:
            'authenticate' => env('LDAP_USER_ATTRIBUTE', 'distinguishedname'),

        ],

        // replace this line:
        // 'eloquent' => 'email',
        // with this one:
        'eloquent' => 'username',

    ],

    'sync_attributes' => [
        // 'field_in_local_db' => 'attribute_in_ldap_server',
        'username' => 'uid', // was 'email' => 'userprincipalname',
        'name' => 'cn',
        'phone' => 'telephonenumber',
    ],

];
