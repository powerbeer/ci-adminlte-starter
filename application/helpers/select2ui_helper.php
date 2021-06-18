<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if (!function_exists('generate_select2')) {

    function generate_select2($config) {

        $not_show_id = @$config['not_show_id'];
        if ($not_show_id == false) {
            $label_show = 'obj.id +"-"+obj.desc';
        } else {
            $label_show = 'obj.desc';
        }

//$id,$url_ajax,$minimumInputLength=2,$link_id=""

        $html = '$("#' . @$config['name'] . '").select2({ 
		                dropdownAutoWidth: true, 
		                width: \'100%\',';

        if (isset($config['readonly'])) {
            if ($config['readonly'] == true) {
                $html .= 'disabled: true,';
            }
        }
        if (isset($config['dropdownParent'])) {
            if ($config['dropdownParent'] == true) {
                $html .= "dropdownParent: $('#" . $config['dropdownParent'] . "'),";
            }
        }

        if (!isset($config['minimumInputLength'])) {
            
        } else if (@$config['minimumInputLength'] == '') {
            $config['minimumInputLength'] = '0';
        } else {
            if ($config['minimumInputLength'] > 0) {
                $html .= '      minimumInputLength: ' . @$config['minimumInputLength'] . ',';
            }
        }
        $html .= '
		                ajax: {
					        url: "' . site_url("lookup/Lookup/get/" . $config['table'] . '/' . $config['id'] . '/' . $config['desc']) . '",
					        dataType: \'json\',
					        type: "GET",
					        quietMillis: 50,
					        data: function (params) {
					            return {';
        if (@$config['link_id'] != '') {
            $html .= 'id_link:$("#' . @$config['link_id'] . '").val(), ';
        }
        $html .= '  txtsearch: params.term
					            };
					        },
					          processResults: function (data) {
							    return {
							        results: $.map(data, function(obj) {
							            return { id: obj.id, text: ' . $label_show . '  };
							        })
							    };
							}
					        }
                 });
                 
                 ';
//  $ci = &get_instance();
// $html=$ci->webutils->Minifier_script($html);
//   echo $html;
        $CI = &get_instance();
        echo $CI->ugly->js($html) . "\n\r\n\r\n\r ";
    }

}
?>
