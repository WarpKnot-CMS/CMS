<?php
/**
 * @package   WarpKnot
 */

/**
 * Dashboard routing system
 *
 * Static route e.g. /example/list
 *
 */
return [
    /**
     * Images Upload
     */
    'filesmanagement/upload/images' => [
        'module'         => 'FilesManagement',
        'namespace'      => 'FilesManagement',
        'action'         => 'UploadImages',
        'type'           => 'static',
        'methods'        => [
            'post'
        ],
        'required_roles' => [
            'authenticated'
        ],
        'redirect_page'  => '',
        'local_template' => false
    ],
    /**
     * Files Upload
     */
    'filesmanagement/upload/files'  => [
        'module'         => 'FilesManagement',
        'namespace'      => 'FilesManagement',
        'action'         => 'UploadFiles',
        'type'           => 'static',
        'methods'        => [
            'post'
        ],
        'required_roles' => [
            'authenticated'
        ],
        'redirect_page'  => '',
        'local_template' => false
    ],
    'filesmanagement/load'          => [
        'module'         => 'FilesManagement',
        'namespace'      => 'FilesManagement',
        'action'         => 'Load',
        'type'           => 'static',
        'methods'        => [
            'get'
        ],
        'required_roles' => [
            'authenticated'
        ],
        'redirect_page'  => '',
        'local_template' => false
    ],
    /**
     * Files List
     */
    'admin/files'                   => [
        'module'         => 'FilesManagement',
        'namespace'      => 'FilesManagement',
        'action'         => 'List',
        'type'           => 'static',
        'methods'        => [
            'get'
        ],
        'required_roles' => [
            'administrator'
        ],
        'local_template' => true
    ],
    'admin/files/post'              => [
        'module'         => 'FilesManagement',
        'namespace'      => 'FilesManagement',
        'action'         => 'Management',
        'type'           => 'static',
        'methods'        => [
            'post'
        ],
        'required_roles' => [
            'administrator'
        ],
        'redirect_page'  => '',
        'local_template' => false
    ],
];