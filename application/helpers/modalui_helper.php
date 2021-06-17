<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if (!function_exists('generate_modal')) {

    function generate_modal($config = null) {
        $js_gen = "$('#" . $config['modal_id'] . "').modal({backdrop: 'static', keyboard: false});";
        echo $js_gen;
    }

}



 
?>
