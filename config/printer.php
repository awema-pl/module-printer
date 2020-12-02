<?php
return [
    // this resources has been auto load to layout
    'dist' => [
        'js/main.js',
        'js/main.legacy.js',
        'css/main.css',
    ],
    'routes' => [
        // all routes is active
        'active' => true,
        // section installations
        'installation' => [
            'active' => true,
            'prefix' => '/installation/printer',
            'name_prefix' => 'printer.installation.',
            // this routes has beed except for installation module
            'expect' => [
                'module-assets.assets',
                'printer.installation.index',
                'printer.installation.store',
            ]
        ],

        'setting' => [
            'active' => true,
            'prefix' => '/admin/printer/settings',
            'name_prefix' => 'printer.setting.',
            'middleware' => [
                'web',
                'auth',
                'can:manage_printer_settings'
            ]
        ],

        'printer' => [
            'active' => true,
            'prefix' => '/printer/printers',
            'name_prefix' => 'printer.printer.',
            'middleware' => [
                'web',
                'auth',
                'verified'
            ]
        ],

        'nodeprinter' => [
            'active' => true,
            'prefix' => '/printer/nodeprinters',
            'name_prefix' => 'printer.nodeprinter.',
            'middleware' => [
                'web',
                'auth',
                'verified'
            ]
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Use permissions in application.
    |--------------------------------------------------------------------------
    |
    | This permission has been insert to database with migrations
    | of module permission.
    |
    */
    'permissions' =>[
        'install_packages', 'manage_printer_settings',
    ],

    /*
    |--------------------------------------------------------------------------
    | Can merge permissions to module permission
    |--------------------------------------------------------------------------
    */
    'merge_permissions' => true,

    'installation' => [
        'auto_redirect' => [
            // user with this permission has been automation redirect to
            // installation package
            'permission' => 'install_packages'
        ]
    ],

    'database' => [
        'tables' => [
            'users' => 'users',
            'printer_settings' => 'printer_settings',
            'printer_printers' =>'printer_printers',
            'printer_nodeprinters' =>'printer_nodeprinters',
        ]
    ],

];
