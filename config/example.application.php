<?php
/**
 * @package   WarpKnot
 */

/**
 * CMS configuration
 */
return [
    // CMS Version
    'version'           => '1.0',

    // Enable Debug
    'debug'             => false,

    // Enable Development
    'development'       => false,

    // HTML Minify
    'html_minify'       => true,

    // Pagination Limit
    'pagination_limit'  => 10,

    // Secure Token
    '_SECURE'           => '',

    // Set server timezone
    '_TIMEZONE'         => '',

    // Date Format
    '_DATE_FORMAT'      => 'm.d.Y',
    '_FULL_DATE_FORMAT' => 'm.d.Y - h:i:s',
    '_HOUR_FORMAT'      => 'h:i:s',

    // Theme Directory
    '_THEME'            => 'default',

    // Static Directory
    '_STATIC'           => '',

    // File Uploads
    '_FILE_UPLOADS'     => [
        '_IMAGES' => [
            'gif',
            'jpg',
            'png'
        ],
        '_FILES'  => [
            'doc',
            'docx',
            'odt',
            'pdf',
            'xls',
            'xlsx',
            'ods',
            'ppt',
            'pptx',
            'txt'
        ]
    ],

    // Google Recaptcha
    '_RECAPTCHA'        => [
        'SITE_KEY'   => '',
        'SECRET_KEY' => ''
    ],

    '_USER'                => [
        'LOGIN'    => true,
        'REGISTER' => true
    ],

    // Website Url
    '_DOMAIN'              => $_SERVER['HTTP_HOST'],

    // Subdirectory
    '_SUBDIRECTORY'        => '',

    // Domain Root
    '_DOMAIN_ROOT'         => (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . DIRECTORY_SEPARATOR,

    // Name
    '_NAME_FRONT'          => 'ApplicationName',
    '_NAME_DASHBOARD'      => 'ApplicationName',

    // Resources : Admin
    '_ADMIN_JS_RESOURCES'  => [
        '/themes/admin/dist/scripts/lib.js',
        '/themes/admin/assets/sources/libraries/tinymce/js/tinymce/tinymce.min.js',
        '/themes/admin/dist/scripts/script.js'
    ],
    '_ADMIN_CSS_RESOURCES' => [
        'https://fonts.googleapis.com/css?family=Roboto:300,400,500',
        '/themes/admin/dist/styles/main.css'
    ],

    // Resources : Front
    '_FRONT_JS_RESOURCES'  => [
        '/themes/default/dist/scripts/lib.js',
        '/themes/default/dist/scripts/script.js'
    ],
    '_FRONT_CSS_RESOURCES' => [
        'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700',
        '/themes/default/dist/styles/main.css'
    ]
];