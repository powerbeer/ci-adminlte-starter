<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



if (!function_exists('generate_dropify')) {

    function generate_dropify($config = null) {
        $config_ = "{
            messages: {
                'default': 'คลิกอัปโหลดรูปภาพ',
                'replace': 'คลิกเพื่อแก้ไขรูปภาพ',
                'remove':  'ยกเลิก',
                'error':   'โอ๊ะโอ! เกิดข้อผิดพลาดบางอย่าง'
            }
            }";
        $js_gen = "$('.dropify').dropify(" . $config_ . ");";
        echo $js_gen;
    }

}
?>
