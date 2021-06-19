<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if (!function_exists('create_form_id')) {

    function create_form_id() {
        $html = "f_" . rand(100, 10000);
        return $html;
    }

}


if (!function_exists('form_search')) {

    function form_search($url, $search_text = "") {

        $html ='<div class="input-group  w-300"  >
              <form class="form-inline" method="POST" action="' . $url . '"> 
                            <input type="text"  name="search_text"  id="search_text" value="' . $search_text . '"   class="form-control float-right" placeholder="ค้นหาข้อมูล">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            </form>
                        </div>';
        return $html; 
    }

}

if (!function_exists('form_input')) {

    function form_input($id, $name, $label, $value = "", $config = array()) {

        $max_length_text = '';
        $require_text='';
        $placeholder = @$config['placeholder'];
        $require=@$config['require'];
        $type = @$config['type'];
        $readonly = @$config['readonly'];
        if ($readonly == true) {
            $readonly = 'readonly';
        } else {
            $readonly = '';
        }
        if($require==true){
            $require_text='<label class="red">*</label>';
        }
        if (empty($type)) {
            $type = 'text';
        }
        $max_length = @$config['max_length'];
        if (!empty($max_length)) {
            $max_length_text = 'maxlength="' . $max_length . '"';
        } else {
            $max_length_text = 'maxlength="255"';
        }
        $html = '
            <div class="form-group">
                            <label for="' . $id . '">' . $label . ' '. $require_text. ' </label>
                            <input type="' . $type . '" class="form-control" id="' . $id . '" name="' . $name . '" placeholder="' . $placeholder . '"  ' . $readonly . '   value="' . $value . '" ' . $max_length_text . '  autocomplete="off"  />
                        </div> ';
        return $html;
    }

}



if (!function_exists('form_input_html')) {

    function form_input_html($id, $label, $html) {

        $html = '
                           <div class="form-group">
                            <label for="' . $id . '">' . $label . '</label>
                        ' . $html  .'  </div> ';
        return $html;
    }

}




if (!function_exists('text_label_red')) {

    function text_label_red($txt, $color = "red") {

        $html = '<font color="red"> ' . $txt . '</font>';
        return $html;
    }

}




if (!function_exists('generate_maxlength')) {

    function generate_maxlength($config = null) {
        $id = $config['id'];
        $threshold = $config['threshold'];
        $js_gen = "$('#" . $id . "').maxlength({
                alwaysShow: true,
                threshold: " . $threshold . ",
                warningClass: \"label label-info\",
                limitReachedClass: \"label label-warning\",
                placement: 'top',
                preText: 'ใช้ไป ',
                separator: ' จาก ',
                postText: ' ตัวอักษร.'
            });
        ";

        echo $js_gen;
    }

}
?>
