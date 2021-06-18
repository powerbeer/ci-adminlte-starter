<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if (!function_exists('datatable_thead')) {

    function datatable_thead($label, $url_click = "javascript:void(0);", $w = 'w-100') {
        //$url_click=$url_main .
        $html = '';
        $html = '  <th class="font-weight-bold ' . $w . '">
                                 <a href="' . $url_click . '">  ' . $label . ' </a>
                                </th>';
        return $html;
    }

}



if (!function_exists('datatable_nodata')) {

    function datatable_nodata($message_title_notfound, $colspan ) {
        $html = '';

        $html = '  <tr><td colspan="'.$colspan.'"><div class="  text-center">
                <div >
                  <i class="icon fa-exclamation-circle" aria-hidden="true" style="font-size: 64px;"></i>
                  <h4 class="title">' . $message_title_notfound . '</h4> ';

        $html .= '  </div>
              </div></td></tr>';

        return $html;
    }

}

if (!function_exists('datatable_row')) {

    function datatable_row($list_data = array()) {
        $html = '';

        $html = '<tr id=""> </tr>';

        return $html;
    }

}




 