<?php
/**
 * @package   WarpKnot
 */

/**
 * Application custom settings
 */

return [
    'admin_dashboard' => [
        'widgets' => [
            'top'    => [
                'User',
                'Pages',
                'Blog',
                'FilesManagement'
            ],
            'bottom' => [
                'User'            => [
                    'limit' => 10,
                ],
                'Pages'           => [
                    'limit' => 10
                ],
                'Blog'            => [
                    'limit' => 10
                ],
                'FilesManagement' => [
                    'limit' => 10
                ]
            ]
        ]
    ],
    'user_dashboard'  => [
        'widgets' => [
            'top'    => [

            ],
            'bottom' => [

            ]
        ]
    ],
];