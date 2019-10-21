<?php
/**
 * @package   WarpKnot
 */

use _MODULE\FilesManagement;
use _MODULE\PageBuilder\_FORM;
use _WKNT\_HOOK;
use _WKNT\_MESSAGE;
use _WKNT\_REQUEST;
use _WKNT\_TEMPLATE;

/**
 * @param $directory
 * @param $file
 *
 * @return mixed
 */
function render($directory, $file)
{
    global $__DIRECTORIES, $_APP_CONFIG;

    return _TEMPLATE::$_VIEW->render($__DIRECTORIES['_THEME'] . $_APP_CONFIG['_THEME'] . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . $file);
}

/**
 * @param $directory
 * @param $file
 * @return mixed
 */
function selfRender($directory, $file)
{
    global $__DIRECTORIES, $_APP_CONFIG;
    $_OVERWRITE = $__DIRECTORIES['_THEME'] . $_APP_CONFIG['_THEME'] . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . $file;

    if (file_exists($_OVERWRITE)):
        return _TEMPLATE::$_VIEW->render($_OVERWRITE);
    else:
        return _TEMPLATE::$_VIEW->render($__DIRECTORIES['_MODULE'] . $directory . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . $file);
    endif;
}

/**
 * @return string
 */
function jsResourcesAdmin()
{
    global $_APP_CONFIG;

    foreach ($_APP_CONFIG['_ADMIN_JS_RESOURCES'] as $RESOURCE):
        echo '<script src="' . $RESOURCE . '"></script>';
    endforeach;

    /**
     * Add extra resources to the admin js
     */
    _HOOK::execute('jsResourcesAdmin');
}

/**
 * @return string
 */
function cssResourcesAdmin()
{
    global $_APP_CONFIG;

    foreach ($_APP_CONFIG['_ADMIN_CSS_RESOURCES'] as $RESOURCE):
        echo '<link href="' . $RESOURCE . '" rel="stylesheet">';
    endforeach;

    /**
     * Add extra resources to the admin css
     */
    _HOOK::execute('cssResourcesAdmin');
}

/**
 * @return string
 */
function jsResources()
{
    global $_APP_CONFIG;

    /**
     * Add extra resources to the js
     */
    _HOOK::execute('jsResources');

    $resources = [];
    foreach ($_APP_CONFIG['_FRONT_JS_RESOURCES'] as $RESOURCE):
        $resources[] = '<script src="' . $RESOURCE . '"></script>';
    endforeach;

    return implode("", $resources);
}

/**
 * @return string
 */
function cssResources()
{
    global $_APP_CONFIG;

    /**
     * Add extra resources to the css
     */
    _HOOK::execute('cssResources');

    $resources = [];
    foreach ($_APP_CONFIG['_FRONT_CSS_RESOURCES'] as $RESOURCE):
        $resources[] = '<link href="' . $RESOURCE . '" rel="stylesheet">';
    endforeach;

    return implode("", $resources);
}


/**
 * GET
 */
function _get($variable)
{
    return (isset($_GET[$variable]) ? $_GET[$variable] : '');
}

/**
 * @param $containerClass
 *
 * @return string
 */
function messages($containerClass)
{
    $messages = _MESSAGE::all();
    if (empty($messages)) {
        return '';
    }
    $html = [];
    foreach ($messages as $message):
        $html[] = '<div class="alert alert-' . $message['type'] . '" role="alert">' . $message['message'] . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    endforeach;

    return '<div class="' . $containerClass . '">' . implode("", $html) . '</div>';
}


function formDisplay($formID)
{
    return _FORM::display($formID);
}

/**
 * @param $file
 *
 * @return string
 */
function fileSrc($file)
{
    global $_APP_CONFIG;

    return $_APP_CONFIG['_DOMAIN_ROOT'] . 'uploads' . DIRECTORY_SEPARATOR . $file;
}

/**
 * @param $file
 * @param $style
 * @return string
 */
function fileIcon($file, $style)
{
    global $_APP_CONFIG;
    $iconDetails = explode(".", $file);
    $icon        = is_array($iconDetails) ? end($iconDetails) : $iconDetails;

    return $_APP_CONFIG['_DOMAIN_ROOT'] . 'themes' . DIRECTORY_SEPARATOR . $_APP_CONFIG['_THEME'] .
           DIRECTORY_SEPARATOR . 'dist' .
           DIRECTORY_SEPARATOR . 'images' .
           DIRECTORY_SEPARATOR . 'icons' .
           DIRECTORY_SEPARATOR . (empty($style) ? 'classic' : $style) .
           DIRECTORY_SEPARATOR . $icon . '.svg';
}


/**
 * @param $bytes
 * @return string
 */
function fileToSize($file)
{
    return FilesManagement::getFileSize($file);
}

/**
 * @param $object
 *
 * @return string
 */
function webLink($object)
{
    global $_APP_CONFIG;

    return (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') . $object;
}

function currentPage($link)
{
    $url = _REQUEST::_URI();
    if (isset($url['_LINK'])):
        return $link === $url['_LINK'] ? true : false;
    else:
        return false;
    endif;
}

/**
 * @param $filename
 * @return string
 */
function distSrc($filename)
{
    global $_APP_CONFIG;

    return $_APP_CONFIG['_DOMAIN_ROOT'] . 'themes' . DIRECTORY_SEPARATOR . $_APP_CONFIG['_THEME'] . DIRECTORY_SEPARATOR . 'dist' . DIRECTORY_SEPARATOR . $filename;
}

/**
 * @param $object
 * @return string
 * @throws Exception
 */
function imageResize($object)
{
    return FilesManagement::imageResize($object);
}

/**
 * @param string $group
 * @return string
 * @throws Exception
 */
function pageBuilderLoad($group = '')
{
    return _MODULE\PageBuilder\_LOAD::execute($group);
}