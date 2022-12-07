<?php

return [

    'connections' => [

        'default' => [
            'auto_connect' => env('LDAP_AUTO_CONNECT', false),
            'connection' => Adldap\Connections\Ldap::class,
            'settings' => [

                // replace this line:
                // 'schema' => Adldap\Schemas\ActiveDirectory::class,
                // with this:
                'schema' => env('LDAP_SCHEMA', '') == 'OpenLDAP' ?
                    Adldap\Schemas\OpenLDAP::class :
                    ( env('LDAP_SCHEMA', '') == 'FreeIPA' ?
                        Adldap\Schemas\FreeIPA::class :
                        Adldap\Schemas\ActiveDirectory::class ),

                'account_prefix' => env('LDAP_ACCOUNT_PREFIX', ''),
                'account_suffix' => env('LDAP_ACCOUNT_SUFFIX', ''),
                'hosts' => explode(' ', env('LDAP_HOSTS', 'corp-dc1.corp.acme.org corp-dc2.corp.acme.org')),
                'port' => env('LDAP_PORT', 389),
                'timeout' => env('LDAP_TIMEOUT', 5),
                'base_dn' => env('LDAP_BASE_DN', 'dc=corp,dc=acme,dc=org'),
                'username' => env('LDAP_ADMIN_USERNAME', ''),
                'password' => env('LDAP_ADMIN_PASSWORD', ''),
                'follow_referrals' => env('LDAP_FOLLOW_REFERRALS', false),
                'use_ssl' => env('LDAP_USE_SSL', false),
                'use_tls' => env('LDAP_USE_TLS', false),
                'custom_options' => [
                    // See: http://php.net/ldap_set_option
                    LDAP_OPT_X_TLS_REQUIRE_CERT => LDAP_OPT_X_TLS_NEVER
                ]
            ],
        ],

    ],

];
