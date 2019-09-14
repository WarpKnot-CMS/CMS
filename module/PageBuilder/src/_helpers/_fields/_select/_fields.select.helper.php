<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\PageBuilder\Admin;

use _MODULE\PageBuilder;
use _WKNT\_REQUEST;
use _WKNT\_VALIDATE;
use function json_encode;

/**
 * Class _SELECT
 * @package _MODULE\PageBuilder\Admin
 */
class _SELECT
{
    private static $module = 'PageBuilder';

    /**
     *
     */
    public static function execute()
    {
        $variables    = _REQUEST::_VARIABLES(isset(_REQUEST::_POST()['data']) ? _REQUEST::_POST()['data'] : '');
        $selectValues = isset($variables['object_values']) ? json_decode($variables['object_values']) : '';
        $values       = [];
        if (is_object($selectValues)):
            foreach ($selectValues as $key => $value):
                $values[PageBuilder::cleanString($key)] = isset($value) ? PageBuilder::cleanString($value) : PageBuilder::cleanString($key);
            endforeach;
        else:
            if (!empty($selectValues)):
                $options = explode("\n", $selectValues);
                if (!empty($options)):
                    foreach ($options as $value):
                        $option                                       = explode(":", $value);
                        $values[PageBuilder::cleanString($option[0])] = isset($option[1]) ? PageBuilder::cleanString($option[1]) : PageBuilder::cleanString($option[0]);
                    endforeach;
                endif;
            endif;
        endif;

        $data = [
            'tempID'        => '',
            'name'          => isset($variables['name']) ? $variables['name'] : '',
            'machine_name'  => isset($variables['machine_name']) ? $variables['machine_name'] : '',
            'object_values' => isset($variables['object_values']) ? _VALIDATE::is_json($variables['object_values']) ? str_replace("\r\n","&#x0a;",json_decode($variables['object_values'])) : $variables['object_values'] : '',

            'placeholder' => isset($variables['placeholder']) ? $variables['placeholder'] : '',
            'values'      => $values,
            'required'    => isset($variables['required']) ? $variables['required'] : '',
        ];


        PageBuilder::$_VIEW->values = isset($variables['object_values']) ? json_decode($variables['object_values']) : [];
        PageBuilder::$_VIEW->data   = $data;
        return json_encode(
            selfRender(self::$module, 'fields' . DIRECTORY_SEPARATOR . 'select/select.php')
        );
    }
}