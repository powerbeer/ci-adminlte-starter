<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if (!function_exists('generate_validate')) {

    function generate_validate($id_form, $id_btn, $url_post_update, $arr_validators_field, $post_type = 'json', $config = array()) {

        $list_editor = array();
        $js_gen = "";

        $message_alert_lib = "toastr"; // 
        //  $enable_submit=@$config['enable_submit']; 

        if (isset($config['message_alert_lib'])) {  //toastr,swal
            $message_alert_lib = $config['message_alert_lib'];
        }

        for ($i = 0; $i < count($arr_validators_field); $i++) {

            $validate = $arr_validators_field[$i];

            $field = $validate['fields'];
            $validators = $validate['validators'];
            $is_editor = @$validate['is_editor'];
            $required = @$validate['required'];

            if (!isset($required)) {
                $required = true;
            }
            // var_dump($validators);
            //exit();

            if ($is_editor == true) {
                $list_editor[] = $field;
            }

            if ($required == true) {
                $js_gen .= $field . ': { 
                        validators: { ';
                for ($a = 0; $a < count($validators); $a++) {
                    $t = $validators[$a][0];
                    $m = $validators[$a][1];
                    $js_gen .= $t . ': {
                                        message: "' . $m . '"
                                    },';
                }

                $js_gen .= '     }
                    }, ';
            }
        }


    

        $js = '$(document).ready(function () {

        var form_id = "' . $id_form . '";
        var btn_save_id = "' . $id_btn . '";

        $(\'#\' + form_id).formValidation({
            framework: "bootstrap4",
            button: {
                selector: \'#\' + btn_save_id,';

        $js .= 'disabled: \'disabled\'';


        $js .= '},
            icon: null,
            fields: {
                ' . $js_gen . '
            },
            err: {
                clazz: \'invalid-feedback\'
            },
            control: {
             
                 invalid: \'is-invalid\'
            },
            row: {
                invalid: \'has-danger\'
            }
        }).on(\'success.form.fv\', function (e) { 
        
              if(typeof editor !== \'undefined\'){
                  editor.save();
              }
        ';

        for ($i = 0; $i < count($list_editor); $i++) {
            $js .= ' if(typeof ' . $list_editor[$i] . ' !== \'undefined\'){
                  ' . $list_editor[$i] . '.save();
              } ';
        }

        if ($post_type == JSON) {
            $js .= '
                 e.preventDefault(); 
                 $.httpPost(\'' . $url_post_update . '\', form_id, \'' . $message_alert_lib . '\');  ';
        } else if ($post_type == 'action') {
            // $js .=' form.submit(); ';
        } else if ($post_type == POST_MULTIPLE) {
            $js .= '   e.preventDefault();   '
                    . '  _httPostMultipleForm(\'' . $url_post_update . '\', form_id).done(function (res) {
                       
                         var rest=JSON.parse(res); 
                       
                    if (rest.message_status == \'error\') {
                        $.messageAlert(\'swal\', \'error\', \'พบข้อผิดพลาด\', rest.message); ';


            $js .= '$("#' . $id_btn . '").removeAttr( "disabled" ); $("#' . $id_btn . '").removeClass( "disabled" ); ';


            $js .= '   }else{ 
                            var v_modal_id = rest.modal_id; 
                               if(!rest.location_reload){
                                    $.messageAlert(\'swal\', \'success\',rest.message,\'\',rest.url_redirect);
                               }
                            if (v_modal_id !== \'\') {
                                $("#" + v_modal_id).modal(\'hide\'); 
                                
                                if(rest.location_reload){
                                      window.location.reload(); 
                               }
                            }
                            
                            
                    }
             }); ';
        } else if ($post_type == 'success_and_show_modal') {
            $js .= '   e.preventDefault();   '
                    . '  _httpPost(\'' . $url_post_update . '\', form_id).done(function (res) {
                    if (res.status == \'error\'  || res.message_status == \'error\' ) {
                        $.messageAlert(\'toastr\', \'error\', \'พบข้อผิดพลาด\', res.message); ';


            $js .= '$("#' . $id_btn . '").removeAttr( "disabled" ); $("#' . $id_btn . '").removeClass( "disabled" );';


            $js .= '    }else{
                       if (typeof res.url_redirect !== \'undefined\') {
                         window.location.href = res.url_redirect;   
                       }else{
                         angular.element($(\'[ng-controller="GlobalController"]\')).scope().loadURLModalLite(res.url_modal);
                       }
                    }
             }); ';
        } else if ($post_type == 'success_and_post_json') {
            $js .= '   e.preventDefault();   '
                    . '  _httpPost(\'' . $url_post_update . '\', form_id).done(function (res) {
                    if (res.status == \'error\') {
                        $.messageAlert(\'toastr\', \'error\', \'พบข้อผิดพลาด\', res.message); ';


            $js .= '$("#' . $id_btn . '").removeAttr( "disabled" );  $("#' . $id_btn . '").removeClass( "disabled" );';


            $js .= '    }else{
                        $.httpPost(res.url_redirect, form_id, \'toastr\');
                    }
             }); ';
        }

        $js .= ' 

        });

    });';
        /*
          $ci = &get_instance();
          $js = $ci->webutils->Minifier_script($js);
         * 
         */
        $CI = &get_instance();
        echo $CI->ugly->js($js) . "\n\r\n\r\n\r ";
      //   echo $js;
    }

}
?>
