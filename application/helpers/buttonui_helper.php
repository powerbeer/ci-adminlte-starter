<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if (!function_exists('ui_modal_form_button_save')) {


    function ui_modal_form_button_save($name = "btnSubmit", $show_closeBtn = true) {
        $html = ' <div class="modal-footer justify-content-between">
                    <button type="submit" id="' . $name . '" class="btn btn-primary">บันทึกข้อมูล</button>';


        if ($show_closeBtn) {
            $html .= '  <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button> ';
        }
        $html .= '     </div>';

        echo $html;
        //   exit();
    }

}


if (!function_exists('ui_button_view_file_upload')) {

    function ui_button_view_file_upload($resource_code = "", $btn_style = " btn-sm") {
        $html = '';
        if (!empty($resource_code)) {
            $html = '  <a type="button" class="btn btn-round   ' . $btn_style . '  white  btn-warning waves-effect waves-classic" href="javascript:void(0)" ng-click="loadURLModalLite(\'' . site_url("FileStore/list_file/" . $resource_code) . '\')" role="menuitem"><i class="fa fa-file"></i> ไฟล์เอกสาร</a>';
        }
        echo $html;
        //   exit();
    }

}
?>
