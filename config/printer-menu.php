<?php

return [
    'merge_to_navigation' => true,

    'navs' => [
        'sidebar' =>[
            [
                'name' => 'Printers',
                'link' => '/printer/printers',
                'icon' => 'speed',
                'key' => 'printer::menus.printers',
                'children_top' => [
                    [
                        'name' => 'All printers',
                        'link' => '/printer/printers',
                        'key' => 'printer::menus.all_printers',
                    ],
                    [
                        'name' => 'PrintNode printers',
                        'link' => '/printer/nodeprinters',
                        'key' => 'printer::menus.printnode_printers',
                    ],
                ],
                'children' => [
                    [
                        'name' => 'All printers',
                        'link' => '/printer/printers',
                        'key' => 'printer::menus.all_printers',
                    ],
                    [
                        'name' => 'PrintNode printers',
                        'link' => '/printer/nodeprinters',
                        'key' => 'printer::menus.printnode_printers',
                    ],
                ],
            ]
        ],
        'adminSidebar' =>[
            [
                'name' => 'Settings',
                'link' => '/admin/printer/settings',
                'icon' => 'speed',
                'permissions' => 'manage_printer_settings',
                'key' => 'printer::menus.printer',
                'children_top' => [
                    [
                        'name' => 'Settings',
                        'link' => '/admin/printer/settings',
                        'key' => 'printer::menus.settings',
                    ],
                ],
                'children' => [
                    [
                        'name' => 'Settings',
                        'link' => '/admin/printer/settings',
                        'key' => 'printer::menus.settings',
                    ],
                ],
            ]
        ]
    ]
];
