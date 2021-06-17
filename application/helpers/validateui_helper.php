<?php

if (!defined('BASEPATH'))
            exit('No direct script access allowed');


        if (!function_exists('generate_validate')) {

            function generate_validate($id_form, $id_btn, $url_post_update, $arr_validators_field, $post_type = 'json', $config = array()) {
                $js = '';

                $js .= "$(function () {
          $.validator.setDefaults({
            submitHandler: function () {
              alert(\"Form successful submitted!\" );
            }
          });
          $('#".$id_form."').validate({
            rules: {
              email: {
                required: true,
                email: true,
              },
              password: {
                required: true,
                minlength: 5
              },
              terms: {
                required: true
              },
            },
            messages: {
              email: {
                required: \"Please enter a email address\",
                email: \"Please enter a vaild email address\"
              },
              password: {
                required: \"Please provide a password\",
                minlength: \"Your password must be at least 5 characters long\"
              },
              terms: \"Please accept our terms\"
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
              error.addClass('invalid-feedback');
              element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
              $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
              $(element).removeClass('is-invalid');
            }
          });
        });";
        echo $js;
    }

}
?>
