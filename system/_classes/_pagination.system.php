<?php
/**
 * @package   WarpKnot
 */

namespace _WKNT;
class _PAGINATION extends _INIT
{

    const _DISABLED_CLASS = 'disabled',
        _HASH_CLASS = 'hasLink';

    /**
     * @param $_DATA
     *
     * @return array
     */
    public static function _GENERATE($_DATA)
    {
        global $_API_CONFIG;
        $_APPEND = '';
        $_VARS   = _REQUEST::_GET_VARIABLES();
        if (!empty($_VARS)):
            $_APPEND .= '?';
            unset($_VARS['p']);
            if (!empty($_VARS)):
                foreach ($_VARS as $KEY => $VAR):
                    $_APPEND .= "$KEY=$VAR&";
                endforeach;
            endif;
            $_APPEND .= 'p=';
        else:
            $_APPEND .= '?p=';
        endif;

        $_HASH_CLASS    = isset($_DATA['_HASHTAG']) ? empty($_DATA['_HASHTAG']) ? '' : self::_HASH_CLASS : '';
        $CURRENT_PAGE   = $_DATA['_CURRENT_PAGE'];
        $TOTAL_ITEMS    = $_DATA['_TOTAL_ITEMS'];
        $ITEMS_PAGE     = $_DATA['_ITEMS_PER_PAGE'];
        $_PAGE_LOCATION = $_API_CONFIG['_DOMAIN_ROOT'] . $_DATA['_PAGE_LINK'] . $_APPEND;
        $_HASHTAG       = isset($_DATA['_HASHTAG']) ? $_DATA['_HASHTAG'] . $_APPEND : '';
        $_CFG           = isset($_DATA['_CFG'])
            ? $_DATA['_CFG']
            :
            [
                '_PRENAME'  => '&#8249;',
                '_HEADNAME' => '&#171;',
                '_NEXTNAME' => '&#8250;',
                'LASTNAME'  => '&#187;'
            ];


        $NUM = '';

        if (empty($CURRENT_PAGE)):
            $CURRENT_PAGE = 1;
        endif;
        $_PAGES_CALCULATOR = ceil($TOTAL_ITEMS / $ITEMS_PAGE);

        if ($_PAGES_CALCULATOR > 1):
            if ($CURRENT_PAGE == 1):
                $nextnum = $CURRENT_PAGE + 1;
            elseif ($CURRENT_PAGE == $_PAGES_CALCULATOR):
                $prenum = $CURRENT_PAGE - 1;
            else:
                $prenum  = $CURRENT_PAGE - 1;
                $nextnum = $CURRENT_PAGE + 1;
            endif;
        else:
            $fp = "''";
        endif;
        if (!empty($prenum)):
            $pre = '<li class="page-item"><a class="page-link ' . $_HASH_CLASS . '" hashtag="' . $_HASHTAG . $prenum . '" href="' . $_PAGE_LOCATION . $prenum . '">' . $_CFG['_PRENAME'] . '</a></li>';
        else:
            $pre = '<li class="page-item ' . $_HASH_CLASS . '" hashtag="' . $_HASHTAG . '" href="' . $_PAGE_LOCATION . '" class="' . self::_DISABLED_CLASS . '"><a href="#" class="page-link ' . self::_DISABLED_CLASS . '">' . $_CFG['_PRENAME'] . '</span></li>';
        endif;
        if (!empty($nextnum)):
            $next = '<li class="page-item"><a class="page-link ' . $_HASH_CLASS . '" hashtag="' . $_HASHTAG . $_CFG['_NEXTNAME'] . '" href="' . $_PAGE_LOCATION . $nextnum . '"> ' . $_CFG['_NEXTNAME'] . ' </a></li>';
        else:
            $next = '<li class="page-item ' . self::_DISABLED_CLASS . '"><span class="page-link ' . self::_DISABLED_CLASS . '">' . $_CFG['_NEXTNAME'] . '</span></li>';
        endif;
        if ($CURRENT_PAGE == 1):
            $head = '<li class="page-item ' . self::_DISABLED_CLASS . '"><span class="page-link ' . self::_DISABLED_CLASS . '">' . $_CFG['_HEADNAME'] . '</span></li>';
        else:
            $head = '<li class="page-item"><a class="page-link ' . $_HASH_CLASS . '" hashtag="' . $_HASHTAG . '1" href=" ' . $_PAGE_LOCATION . '1">' . $_CFG['_HEADNAME'] . '</a></li>';
        endif;
        if ($CURRENT_PAGE == $_PAGES_CALCULATOR):
            $last = '<li class="page-item disabled"><a href="#" class="page-link">' . $_CFG['LASTNAME'] . '</a></li>';
        else:
            $last = '<li class="page-item"><a class="page-link ' . $_HASH_CLASS . '" hashtag="' . $_HASHTAG . $_PAGES_CALCULATOR . '" href="' . $_PAGE_LOCATION . $_PAGES_CALCULATOR . '">' . $_CFG['LASTNAME'] . '</a></li>';
        endif;

        if ($_PAGES_CALCULATOR <= 7):
            $ifrom = 1;
            $ito   = $_PAGES_CALCULATOR;
        else:
            if ($CURRENT_PAGE <= 4):
                $ifrom = 1;
                $ito   = 7;
            elseif ($_PAGES_CALCULATOR - $CURRENT_PAGE <= 3):
                $ifrom = $CURRENT_PAGE - 6 + $_PAGES_CALCULATOR - $CURRENT_PAGE;
                $ito   = $_PAGES_CALCULATOR;
            else:
                $ifrom = $CURRENT_PAGE - 3;
                $ito   = $CURRENT_PAGE + 3;
            endif;
        endif;

        for ($i = $ifrom; $i <= $ito; $i++):
            if ($i == $CURRENT_PAGE):
                $NUM .= '<li class="page-item disabled"><a href="#" class="page-link">' . $i . '</a></li>';
            else:
                $NUM .= '<li class="page-item"><a class="page-link ' . $_HASH_CLASS . '" hashtag="' . $_HASHTAG . $i . '" href="' . $_PAGE_LOCATION . $i . '">' . $i . '</a></li>';
            endif;
        endfor;

        if ($TOTAL_ITEMS <= $ITEMS_PAGE):
            $_HTML = '';
        else:
            $_HTML = $head . $pre . $NUM . $next . $last;
        endif;

        $_LIMIT_START = ($CURRENT_PAGE - 1) * $ITEMS_PAGE;
        $_LIMIT_END   = ($CURRENT_PAGE * $ITEMS_PAGE) - ($CURRENT_PAGE - 1) * $ITEMS_PAGE;
        $_ITEMS       = array_splice($_DATA['_ITEMS'], $_LIMIT_START, $_LIMIT_END);

        return [
            '_HTML'         => "<ul class=\"pagination justify-content-end\">$_HTML</ul>",
            '_ITEMS'        => $_ITEMS,
            '_CURRENT_PAGE' => $CURRENT_PAGE,
            '_LIMIT_START'  => $_LIMIT_START,
            '_LIMIT_END'    => $_LIMIT_END
        ];
    }

    /**
     * @return string
     */
    public static function _CURRENT_PAGE()
    {
        if (strpos(_REQUEST::_REQUEST_URI(), '?p=') !== false) :
            return (count(explode("?p=", _REQUEST::_REQUEST_URI())) == 1) ? '1' : explode("?p=", _REQUEST::_REQUEST_URI())['1'];
        else:
            return (count(explode("&p=", _REQUEST::_REQUEST_URI())) == 1) ? '1' : explode("&p=", _REQUEST::_REQUEST_URI())['1'];
        endif;
    }

}