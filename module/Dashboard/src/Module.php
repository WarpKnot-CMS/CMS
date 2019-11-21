<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE;

use _MODULE\User\_ACCOUNT;
use _WKNT\_INIT;
use _WKNT\_REQUEST;
use _WKNT\_ROUTE;
use function json_encode;

/**
 * Class Dashboard
 * @package _MODULE
 */
class Dashboard extends _INIT
{

    private static $module = 'Dashboard';

    /**
     * Dashboard Homepage
     */
    public static function getIndexAction()
    {
        global $_TRANSLATION;

        self::$_VIEW->menu             = 'dashboard';
        self::$_VIEW->page_title       = $_TRANSLATION['dashboard']['index']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['dashboard']['index']['seo_description'];

        self::template('index.php');
    }

    /**
     * Dashboard Homepage - User
     */
    public static function getUserIndexAction()
    {
        global $_TRANSLATION;

        if (_ACCOUNT::_isAdmin()):
            _ROUTE::_REDIRECT('admin');
        endif;

        self::$_VIEW->menu             = 'dashboard';
        self::$_VIEW->page_title       = $_TRANSLATION['dashboard']['index']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['dashboard']['index']['seo_description'];

        self::template('index.user.php');
    }

    /**
     * Generate the dashboard template
     *
     * @param $page
     */
    private static function template($page)
    {
        self::$_VRS = [
            'header'  => selfRender(self::$module, 'partials/header.php'),
            'footer'  => selfRender(self::$module, 'partials/footer.php'),
            'content' => selfRender(self::$module, $page)
        ];
    }

    /**
     * User Profile Manage
     */
    public static function getUserAction()
    {
        global $_TRANSLATION;

        self::$_VIEW->menu             = 'user';
        self::$_VIEW->page_title       = $_TRANSLATION['dashboard']['user']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['dashboard']['user']['seo_description'];

        /**
         * Load the current user details
         */
        self::$_VIEW->user = _ACCOUNT::_current();

        self::template('user.php');
    }


    /**
     * Return the admin link based on the role
     *
     * @return string
     */
    public static function dashboardLink()
    {
        return in_array('administrator', _ACCOUNT::_getRoles()) ? 'admin' : 'dashboard';
    }

    /**
     * Admin dashboard Widgets
     * @param $name
     * @param $position
     * @param $dashboard
     */
    public static function availableWidgets($name, $position, $dashboard = 'admin_dashboard')
    {
        global $_APP_SETTINGS;
        if (isset($_APP_SETTINGS[$dashboard]) && isset($_APP_SETTINGS[$dashboard]['widgets'])):
            if (isset($_APP_SETTINGS[$dashboard]['widgets'][$position])):
                $i = 0;
                foreach ($_APP_SETTINGS[$dashboard]['widgets'][$position] as $key => $module):
                    if (is_array($module)):
                        if (method_exists('\_MODULE\\' . $key, $key . $name . $position)):
                            call_user_func_array(
                                array('\_MODULE\\' . $key, $key . $name . $position),
                                [$module]
                            );
                        endif;
                    else:
                        if (method_exists('\_MODULE\\' . $module, $module . $name . $position)):
                            call_user_func_array(
                                array('\_MODULE\\' . $module, $module . $name . $position),
                                []
                            );
                        endif;
                    endif;
                    $i++;
                endforeach;
            endif;
        endif;
    }

    /**
     * Dashboard $_POST management
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
                        'type' => 'error',
                        'text' => $_TRANSLATION['user']['invalid_request']
                    ],
                    'redirect' => false
                ]);
        endif;
    }
}