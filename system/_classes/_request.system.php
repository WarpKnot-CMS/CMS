<?php
/**
 * @package   WarpKnot
 */

namespace _WKNT;
class _REQUEST extends _INIT
{
    /**
     * Get Method
     */
    static function _METHOD()
    {
        return strtolower(_SANITIZE::input($_SERVER['REQUEST_METHOD']));
    }

    /**
     * Dynamic request link
     *
     * @return mixed
     */
    static function _REQUEST_ID()
    {
        $_URI         = _REQUEST::_URI();
        $_ROUTE_COUNT = count(explode("/", _ROUTE::$_CURRENT_KEY));
        $_KEYS        = substr_count(_ROUTE::$_CURRENT_KEY, '{var}');

        return array_slice($_URI['_EXTEND'], ($_ROUTE_COUNT - $_KEYS));
    }

    /**
     * Alter the REQUEST_URI in order to remove the subdomain from the list
     *
     * @return mixed
     */
    static function _REQUEST_URI()
    {
        global $_APP_CONFIG;
        if (isset($_APP_CONFIG['_SUBDIRECTORY'])):
            return str_replace(
                $_APP_CONFIG['_SUBDIRECTORY'],
                '',
                $_SERVER['REQUEST_URI']
            );
        else:
            return $_SERVER['REQUEST_URI'];
        endif;
    }

    /**
     * Return URI
     */
    static function _URI()
    {
        $_REQUEST_URI = _SANITIZE::input(self::_REQUEST_URI());

        return [
            "_REQUEST" => $_REQUEST_URI,
            "_LINK"    => trim($_REQUEST_URI, "/"),
            "_ROUTE"   => explode("?", ltrim($_REQUEST_URI, '/')),
            "_EXTEND"  => array_filter(explode("/", explode("?", ltrim($_REQUEST_URI, '/'))['0']))
        ];
    }

    static function _GET_VARIABLES()
    {
        $_GET_SAFE = [];
        if (!empty($_GET)):
            foreach ($_GET as $key => $value):
                $_GET_SAFE[$key] = _SANITIZE::input($value);
            endforeach;
        endif;

        return $_GET_SAFE;
    }

    /**
     * @return bool
     */
    public static function _IS_HOME()
    {
        $_URI = self::_URI();
        if (empty($_URI['_REQUEST']) or $_URI['_REQUEST'] == '/' or substr($_URI['_REQUEST'], 0, 2) == '/?'):
            return true;
        else:
            return false;
        endif;
    }


    /**
     * Return POST data
     */
    static function _POST()
    {
        return $_POST;
    }


    /**
     * @param $_DATA
     *
     * @return array
     */
    static function _VARIABLES($_DATA)
    {
        $_VARIABLES = [];
        if (!empty($_DATA) && is_array($_DATA)):
            foreach ($_DATA as $KEY => $OBJ):
                switch ($KEY):
                    case'editor_read':
                        $array = json_decode($OBJ);
                        if (!empty($array)):
                            foreach ($array as $key => $item):
                                $_VARIABLES[$key] = _SANITIZE::textarea($item);
                            endforeach;
                        endif;
                        break;

                    case'multiple_read':
                        $array = json_decode($OBJ);
                        if (!empty($array)):
                            foreach ($array as $key => $item):
                                $_VARIABLES[$key]             = $item;
                                $_VARIABLES['multiple'][$key] = $item;
                            endforeach;
                        endif;
                        break;

                    case'form_serialize':
                        $array = [];
                        parse_str($OBJ, $array);

                        if (!empty($array)):
                            foreach ($array as $key => $item):
                                if (!isset($_VARIABLES[$key])) {
                                    $_VARIABLES[$key] = _SANITIZE::input($item);
                                }
                            endforeach;
                        endif;
                        break;

                    case'pageBuilder':
                        $array = json_decode($OBJ, true);
                        if (!empty($array)):
                            foreach ($array as $key => $item):
                                $_VARIABLES['page_builder'][$key] = $item;
                            endforeach;
                        endif;
                        break;

                    default:
                        break;
                endswitch;
            endforeach;
        endif;

        return $_VARIABLES;
    }

    /**
     * @param $validation
     * @param $variables
     *
     * @return array
     */
    static public function _VALIDATE($validation, $variables)
    {
        $errors = [];
        foreach ($validation as $key => $check) {
            foreach ($check as $item => $key_check) {

                if (isset($variables[$key])):
                    switch ($key_check):
                        case 'not_empty':
                            if (empty(self::_CLEAN_STRING($variables[$key])) && $variables[$key] != '0') {
                                $errors[$key][] = '<div>' . str_replace(
                                        [
                                            "_",
                                            "-"
                                        ], [
                                        " ",
                                        " "
                                    ], ucfirst($key)) . " field can't be empty." . '</div>';
                            }
                            break;
                        case 'email':
                            if (!filter_var($variables[$key], FILTER_VALIDATE_EMAIL)) {
                                $errors[$key][] = "Invalid email address.";
                            }
                            break;
                        case 'equal':
                            if ($variables[$key] != $item) {
                                $errors[$key][] = '<div>' . str_replace(
                                        [
                                            "_",
                                            "-"
                                        ], [
                                        " ",
                                        " "
                                    ], ucfirst($key)) . " field has an invalid value." . '</div>';
                            }
                            break;
                    endswitch;

                else:
                    switch ($key_check):
                        case 'not_empty':
                            if (empty($variables[$key])) {
                                $errors[$key][] = '<div>' . str_replace(
                                        [
                                            "_",
                                            "-"
                                        ], [
                                        " ",
                                        " "
                                    ], ucfirst($key)) . " field can't be empty." . '</div>';
                            }
                            break;
                        case 'email':
                            if (isset($variables[$key])):
                                if (!filter_var($variables[$key], FILTER_VALIDATE_EMAIL)) {
                                    $errors[$key][] = "Invalid email address.";
                                }
                            endif;
                            break;
                        case 'equal':
                            if (isset($variables[$key])):
                                if ($variables[$key] != $item) {
                                    $errors[$key][] = '<div>' . str_replace(
                                            [
                                                "_",
                                                "-"
                                            ], [
                                            " ",
                                            " "
                                        ], ucfirst($key)) . " field has an invalid value." . '</div>';
                                }
                                break;
                            endif;
                    endswitch;

                endif;
            }
        }

        return array_reverse($errors);
    }

    public static function _CLEAN_STRING($_STRING)
    {
        return preg_replace('/\s+/', '', $_STRING);
    }

    /**
     * Route details
     *
     * Return current route details based on request
     */
    static function _ROUTE()
    {
        return _ROUTE::_LIST()[_REQUEST::_URI()['_ROUTE']['0']];
    }

}


