<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE;

use _MODULE\User\_ACCOUNT;
use _WKNT\_INIT;
use _WKNT\_PAGINATION;
use _WKNT\_REQUEST;
use _WKNT\_TIME;
use _WKNT\_VALIDATE;
use _WKNT\ImageResize;
use function json_encode;

/**
 * Class FilesManagement
 * @package _MODULE
 */
class FilesManagement extends _INIT
{
    public static $imageFolder = "images/",
        $fileFolder = "files/",
        $imageCacheFolder = "images/cache/",
        $module = 'FilesManagement',
        $moduleTemplate = 'Dashboard',
        $templatesDirectory = 'FilesManagement',
        $websiteTemplate = 'FilesManagement',
        $defaultStatus = 1;


    /**
     * Use the admin_dashboard hook
     * @param array $object
     */
    public static function FilesManagement_admin_dashboard_index_top($object = [])
    {
        $objects            = new _DB\FilesManagement();
        self::$_VIEW->count = $objects->count('fid');
        echo selfRender(self::$module, 'widgets/files.stats.php');
    }

    /**
     * Admin Widget - Bottom
     * @param array $object
     */
    public static function FilesManagement_admin_dashboard_index_bottom($object = [])
    {
        $objects     = new _DB\FilesManagement();
        $objectsList = $objects->search(
            [
                'fields' => [],
                'sort'   => [
                    'fid' => 'desc'
                ],
                'limit'  => isset($object['limit']) ? $object['limit'] : 10
            ]);

        self::$_VIEW->objects = $objectsList;
        echo selfRender(self::$module, 'widgets/files.list.php');
    }

    /**
     * Files List
     */
    public static function getListAction()
    {
        global $_TRANSLATION, $_APP_CONFIG;

        $_GET_VARIABLES = _REQUEST::_GET_VARIABLES();
        $filter         = [];

        if (isset($_GET_VARIABLES['filename']) && !empty($_GET_VARIABLES['filename'])):
            $filter['filename'] = [
                'type'  => 'like',
                'value' => '%' . $_GET_VARIABLES['filename'] . '%'
            ];
        endif;

        $objects     = new _DB\FilesManagement();
        $objectsList = $objects->search(
            [
                'fields' => $filter,
                'sort'   => [
                    'fid' => 'desc'
                ]
            ]);

        self::$_VIEW->objects = _PAGINATION::_GENERATE(
            [
                '_HASHTAG'        => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/files',
                '_PAGE_LINK'      => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/files',
                '_CURRENT_PAGE'   => _PAGINATION::_CURRENT_PAGE(),
                '_TOTAL_ITEMS'    => count($objectsList),
                '_ITEMS_PER_PAGE' => $_APP_CONFIG['pagination_limit'],
                '_ITEMS'          => $objectsList
            ]
        );

        /**
         * Check the delete request
         */
        $delete = null;
        if (isset($_GET_VARIABLES['delete'])):
            $object = new _DB\FilesManagement();
            $delete = $object->search(
                [
                    'fields' => [
                        'fid' => [
                            'type'  => '=',
                            'value' => $_GET_VARIABLES['delete']
                        ]
                    ]
                ]);
        endif;

        self::$_VIEW->delete           = $delete;
        self::$_VIEW->menu             = 'files_management';
        self::$_VIEW->sMenu            = 'files_management';
        self::$_VIEW->page_title       = $_TRANSLATION['filesmanagement']['list']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['filesmanagement']['list']['seo_description'];

        self::template('admin/files.php');
    }

    /**
     * Generate the dashboard template
     *
     * @param $page
     */
    private static function template($page)
    {
        self::$_VRS = [
            'header'  => selfRender(self::$moduleTemplate, 'partials/header.php'),
            'footer'  => selfRender(self::$moduleTemplate, 'partials/footer.php'),
            'content' => selfRender('FilesManagement', $page)
        ];
    }

    /**
     * Images Upload
     */
    public static function postUploadImagesAction()
    {
        global $__DIRECTORIES, $_APP_CONFIG;
        $_CACHE_LOCATION = $__DIRECTORIES['_UPLOADS'] . self::$imageCacheFolder;

        $_GET_VARS = _REQUEST::_GET_VARIABLES();

        reset($_FILES);
        $temp = current($_FILES);

        if (is_array($temp['tmp_name'])) {
            $temp['tmp_name'] = $temp['tmp_name'][0];
        }
        if (is_array($temp['name'])) {
            $temp['name'] = $temp['name'][0];
        }

        if (is_uploaded_file($temp['tmp_name'])):
            if (isset($_SERVER['HTTP_ORIGIN'])):
                // same-origin requests won't set an origin. If the origin is set, it must be valid.

                if (in_array(_VALIDATE::getDomain($_SERVER['HTTP_ORIGIN']), [
                    $_APP_CONFIG['_DOMAIN_ROOT'],
                    $_APP_CONFIG['_DOMAIN'],
                    _VALIDATE::getDomain($_APP_CONFIG['_DOMAIN_ROOT'])
                ])):
                    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
                else:
                    header("HTTP/1.1 403 Origin Denied");
                    return;
                endif;
            endif;

            /*
              If your script needs to receive cookies, set images_upload_credentials : true in
              the configuration and enable the following two headers.
            */
            // header('Access-Control-Allow-Credentials: true');
            // header('P3P: CP="There is no P3P policy."');

            // Sanitize input
            if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])):
                header("HTTP/1.1 400 Invalid file name.");
                return;
            endif;

            // Verify extension
            if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), $_APP_CONFIG['_FILE_UPLOADS']['_IMAGES'])):
                header("HTTP/1.1 400 Invalid extension.");
                return;
            endif;

            // Accept upload if there was no origin, or if it is an accepted origin
            $_LOCATION = $__DIRECTORIES['_UPLOADS'] . self::$imageFolder;
            if (!file_exists($_LOCATION)):
                mkdir($_LOCATION);
            endif;

            // Create the caching directory
            $_CACHE_LOCATION = $__DIRECTORIES['_UPLOADS'] . self::$imageCacheFolder;
            if (!file_exists($_CACHE_LOCATION)):
                mkdir($_CACHE_LOCATION);
            endif;

            $temp['name'] = preg_replace('/[^A-Za-z0-9 _ .-]/', '', $temp['name']);
            $filetowrite  = $_LOCATION . $temp['name'];
            $fileName     = $temp['name'];

            $FileCounter = 0;
            while (file_exists($filetowrite)) {
                $filenameExplode = explode(".", $temp['name']);
                $fileExtension   = array_pop($filenameExplode);
                $fileName        = implode("", $filenameExplode) . '-' . $FileCounter . '.' . $fileExtension;
                $filetowrite     = $_LOCATION . $fileName;
                $FileCounter++;
            }

            $fileMove = move_uploaded_file($temp['tmp_name'], $filetowrite);

            $accountSession = _ACCOUNT::_getSession('current_user');
            $uid            = $accountSession['uid'];

            if ($fileMove):
                /**
                 * Save the file location
                 */
                $used_by             = isset($_GET_VARS['location']) ? $_GET_VARS['location'] : '';
                $file                = new \_MODULE\_DB\FilesManagement();
                $file->uid           = $uid;
                $file->filename      = $fileName;
                $file->filegroup     = 'images';
                $file->filetype      = isset($temp['type'][0]) ? $temp['type'][0] : 'blank';
                $file->location      = self::$imageFolder . $fileName;
                $file->used_by       = $used_by;
                $file->uploaded_date = _TIME::_DATE_TIME()['_NOW'];
                $file->create();

                /**
                 * Generate the cache file
                 */
                $image = new ImageResize($__DIRECTORIES['_UPLOADS'] . self::$imageFolder . $fileName);
                $image->resizeToBestFit(300, 230);
                $image->save($_CACHE_LOCATION . $fileName);

                if ($used_by == 'editor'):
                    $imageSrc = $_APP_CONFIG['_DOMAIN_ROOT'] . 'uploads' . DIRECTORY_SEPARATOR . self::$imageFolder . $fileName;
                else:
                    if (file_exists($_CACHE_LOCATION . $fileName)):
                        $imageSrc = $_APP_CONFIG['_DOMAIN_ROOT'] . 'uploads' . DIRECTORY_SEPARATOR . self::$imageCacheFolder . $fileName;
                    else:
                        $imageSrc = $_APP_CONFIG['_DOMAIN_ROOT'] . 'uploads' . DIRECTORY_SEPARATOR . self::$imageFolder . $fileName;
                    endif;
                endif;

                // Respond to the successful upload with JSON.
                // Use a location key to specify the path to the saved image resource.
                // { location : '/your/uploaded/image/file'}
                return json_encode(
                    [
                        "title"        => $fileName,
                        'location'     => $imageSrc,
                        "src_location" => self::$imageFolder . $fileName
                    ]
                );
                exit();
            else:
                // Notify editor that the upload failed
                header("HTTP/1.1 500 File Upload Filed");
            endif;
        else:
            // Notify editor that the upload failed
            header("HTTP/1.1 500 File Error");
        endif;
    }

    /**
     * Files Upload
     */
    public static function postUploadFilesAction()
    {
        global $__DIRECTORIES, $_APP_CONFIG;

        $_GET_VARS = _REQUEST::_GET_VARIABLES();

        reset($_FILES);
        $temp = current($_FILES);
        if (is_array($temp['tmp_name'])) {
            $temp['tmp_name'] = $temp['tmp_name'][0];
        }
        if (is_array($temp['name'])) {
            $temp['name'] = $temp['name'][0];
        }


        if (is_uploaded_file($temp['tmp_name'])):
            if (isset($_SERVER['HTTP_ORIGIN'])):
                // same-origin requests won't set an origin. If the origin is set, it must be valid.

                if (in_array(_VALIDATE::getDomain($_SERVER['HTTP_ORIGIN']), [
                    $_APP_CONFIG['_DOMAIN_ROOT'],
                    $_APP_CONFIG['_DOMAIN'],
                    _VALIDATE::getDomain($_APP_CONFIG['_DOMAIN_ROOT'])
                ])):
                    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
                else:
                    header("HTTP/1.1 403 Origin Denied");
                    return;
                endif;
            endif;

            /*
              If your script needs to receive cookies, set images_upload_credentials : true in
              the configuration and enable the following two headers.
            */
            // header('Access-Control-Allow-Credentials: true');
            // header('P3P: CP="There is no P3P policy."');

            // Sanitize input
            if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])):
                header("HTTP/1.1 400 Invalid file name.");

                return;
            endif;

            // Verify extension
            if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), $_APP_CONFIG['_FILE_UPLOADS']['_FILES'])):
                header("HTTP/1.1 400 Invalid extension.");
                return;
            endif;

            // Accept upload if there was no origin, or if it is an accepted origin
            $_LOCATION = $__DIRECTORIES['_UPLOADS'] . self::$fileFolder;
            if (!file_exists($_LOCATION)):
                mkdir($_LOCATION);
            endif;


            $temp['name'] = preg_replace('/[^A-Za-z0-9 _ .-]/', '', $temp['name']);
            $filetowrite  = $_LOCATION . $temp['name'];
            $fileName     = $temp['name'];

            $FileCounter = 0;
            while (file_exists($filetowrite)) {
                $filenameExplode = explode(".", $temp['name']);
                $fileExtension   = array_pop($filenameExplode);
                $fileName        = implode("", $filenameExplode) . '-' . $FileCounter . '.' . $fileExtension;
                $filetowrite     = $_LOCATION . $fileName;
                $FileCounter++;
            }

            move_uploaded_file($temp['tmp_name'], $filetowrite);

            $accountSession = _ACCOUNT::_getSession('current_user');
            $uid            = $accountSession['uid'];

            /**
             * Save the file location
             */
            $file                = new _DB\FilesManagement();
            $file->uid           = $uid;
            $file->filename      = $fileName;
            $file->filegroup     = 'files';
            $file->filetype      = isset($temp['type'][0]) ? $temp['type'][0] : 'blank';
            $file->location      = self::$fileFolder . $fileName;
            $file->used_by       = isset($_GET_VARS['location']) ? $_GET_VARS['location'] : '';
            $file->uploaded_date = _TIME::_DATE_TIME()['_NOW'];
            $file->create();


            $extensionExplode = explode("/", isset($temp['type'][0]) ? $temp['type'][0] : 'blank');
            if (is_array($extensionExplode)):
                $extension = end($extensionExplode);
            else:
                $extension = empty($file['filetype']) ? 'blank' : $file['filetype'];
            endif;


            // Respond to the successful upload with JSON.
            // Use a location key to specify the path to the saved image resource.
            // { location : '/your/uploaded/image/file'}
            return json_encode(
                [
                    "title"           => $fileName,
                    'location'        => $_APP_CONFIG['_DOMAIN_ROOT'] . 'uploads' . DIRECTORY_SEPARATOR . $fileName,
                    "extension_image" => '/module/FilesManagement/template/sources/images/' . $extension . '.svg',
                    "src_location"    => self::$fileFolder . $fileName
                ]
            );
        else:
            // Notify editor that the upload failed
            header("HTTP/1.1 500 Server Error");
        endif;
    }

    /**
     * Images List
     */
    public static function getLoadAction()
    {
        header('Content-type: application/json');
        global $_APP_CONFIG,
               $__DIRECTORIES;
        $_CACHE_LOCATION = $__DIRECTORIES['_UPLOADS'] . self::$imageCacheFolder;

        $_GET_VARS = _REQUEST::_GET_VARIABLES();
        $group     = isset($_GET_VARS['group']) ? $_GET_VARS['group'] : 'images';

        $file = new _DB\FilesManagement();


        if (in_array('administrator', _ACCOUNT::_getRoles())):
            $fields = [
                'filegroup' => [
                    'type'  => '=',
                    'value' => $group
                ]
            ];
        else:
            $fields = [
                'filegroup' => [
                    'type'  => '=',
                    'value' => $group
                ],
                'condition' => [
                    'value' => 'and'
                ],
                'uid'       => [
                    'type'  => '=',
                    'value' => _ACCOUNT::_getSession('current_user')['uid']
                ]
            ];
        endif;


        $files     = $file->search(
            [
                'fields' => $fields,
                'sort'   => [
                    'fid' => 'desc'
                ]
            ]
        );
        $jsonFiles = [];

        foreach ($files as $file):
            if ($group === 'images'):
                if (file_exists($_CACHE_LOCATION . $file['filename'])):
                    $imageSrc = $_APP_CONFIG['_DOMAIN_ROOT'] . 'uploads' . DIRECTORY_SEPARATOR . self::$imageCacheFolder . $file['filename'];
                /**
                 * Generate the caching file
                 */
                else:
                    if (file_exists($__DIRECTORIES['_UPLOADS'] . $file['location'])):
                        $image = new ImageResize($__DIRECTORIES['_UPLOADS'] . $file['location']);
                        $image->resize(300, 230, true);
                        $image->save($_CACHE_LOCATION . $file['filename']);
                    endif;
                    $imageSrc = $_APP_CONFIG['_DOMAIN_ROOT'] . 'uploads' . DIRECTORY_SEPARATOR . $file['location'];
                endif;
            else:
                $imageSrc = $_APP_CONFIG['_DOMAIN_ROOT'] . 'uploads' . DIRECTORY_SEPARATOR . $file['location'];
            endif;

            $extensionExplode = explode("/", $file['filetype']);
            if (is_array($extensionExplode)):
                $extension = end($extensionExplode);
            else:
                $extension = empty($file['filetype']) ? 'blank' : $file['filetype'];
            endif;

            $jsonFiles[] = [
                "title"           => $file['filename'],
                "value"           => $imageSrc,
                "extension_image" => '/module/FilesManagement/template/sources/images/' . $extension . '.svg',
                "location"        => $file['location']
            ];
        endforeach;

        return json_encode($jsonFiles);
    }

    /**
     * @param $file
     * @return false|int|string
     */
    public static function getFileSize($file)
    {
        global $__DIRECTORIES;

        $_LOCATION = $__DIRECTORIES['_UPLOADS'] . DIRECTORY_SEPARATOR;

        if (file_exists($_LOCATION . $file)):
            $bytes = filesize($_LOCATION . $file);
        else:
            $bytes = 0;
        endif;

        if ($bytes >= 1073741824):
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        elseif ($bytes >= 1048576):
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        elseif ($bytes >= 1024):
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        elseif ($bytes > 1):
            $bytes = $bytes . ' bytes';
        elseif ($bytes == 1):
            $bytes = $bytes . ' byte';
        else:
            $bytes = '0 bytes';
        endif;
        return $bytes;
    }

    /**
     * @param $object
     * @$object['file']
     * @$object['method']
     * @$object['width']
     * @$object['height']
     * @$object['scale']
     * @$object['directory']
     * @return string
     * @throws \Exception
     */
    public static function imageResize($object)
    {
        global $__DIRECTORIES, $_APP_CONFIG;
        $_CACHE_LOCATION = $__DIRECTORIES['_UPLOADS'] . self::$imageCacheFolder;
        if (empty($object['file']))
            return false;
        $fileObject = explode("/", $object['file']);
        $file       = end($fileObject);

        /**
         * Generate the cache file
         */
        if (!file_exists($_CACHE_LOCATION . $object['directory'])):
            mkdir($_CACHE_LOCATION . $object['directory']);
        endif;

        if (!file_exists($_CACHE_LOCATION . $object['directory'] . DIRECTORY_SEPARATOR . $file)):
            $image = new ImageResize($__DIRECTORIES['_UPLOADS'] . self::$imageFolder . $file);
            switch ($object['method']):
                case 'resizeToWidth':
                    $image->resizeToWidth($object['width']);
                    break;
                case 'resizeToHeight':
                    $image->resizeToHeight($object['height']);
                    break;
                case 'resizeToBestFit':
                    $image->resizeToBestFit($object['width'], $object['height']);
                    break;
                case 'scale':
                    $image->scale($object['scale']);
                    break;
                case 'resize':
                    $image->resize($object['width'], $object['height'], (isset($object['allow_enlarge']) ? $object['allow_enlarge'] : false));
                    break;
            endswitch;
            $image->save($_CACHE_LOCATION . $object['directory'] . DIRECTORY_SEPARATOR . $file);
        endif;
        $src = $_APP_CONFIG['_DOMAIN_ROOT'] . 'uploads' . DIRECTORY_SEPARATOR . self::$imageCacheFolder . $object['directory'] . DIRECTORY_SEPARATOR . $file;
        if (isset($object['img_tag']) && $object['img_tag']):
            return '<img id=' . (isset($object['id']) ? $object['id'] : '') . ' title="' . $object['title'] . '" src="' . $src . '"/>';
        else:
            return $src;
        endif;
    }

    /**
     * Gallery Modal
     *
     * @param $modalID
     * @param $object
     * @param $saveTo
     * @param $type
     *
     * @return mixed
     */
    public static function galleryModal()
    {
        return selfRender('FilesManagement', 'gallery_modal.php');
    }

    /**
     * Files Management
     */
    public static function postManagementAction()
    {
        global $_TRANSLATION;

        header('Content-Type: application/json');
        $_METHOD = '\\_MODULE\\' . self::$module . '\\' . _REQUEST::_POST()['data_id'];
        if (method_exists('\\_MODULE\\' . self::$module . '\\' . _REQUEST::_POST()['data_id'], 'execute')):
            $_MODULE = new $_METHOD;
            return $_MODULE->execute();
        else:
            return json_encode(
                [
                    'errors'   => false,
                    'message'  => [
                        'type' => 'danger',
                        'text' => $_TRANSLATION['filesmanagement']['invalid_request']
                    ],
                    'redirect' => false
                ]);
        endif;
    }

}