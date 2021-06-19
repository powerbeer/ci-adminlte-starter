<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if (!function_exists('generate_upload')) {

    function generate_upload($config) {
       $CI = &get_instance();
        $file_list_store = (Array)$CI->session->userdata(SESSION_FILE_LIST);
        $file_store_code = @$file_list_store[SESSION_FILE_STORE_CODE];

        $showDelete = "showDelete: true,";
        if (isset($config['show_delete'])) {
            if ($config['show_delete'] == false) {
                $showDelete = "showDelete: false,";
            }
        }
        $js = ' 
            $(document).ready(function()
            {
                    $("#' . @$config['id'] . '").uploadFile({
                        url:"' . @$config['url_ajax'] . '?cmd=upload",
                        dragDropStr: "<span><b>หรือลากแล้ววางไฟล์ที่นี่</b></span>",
                        abortStr:"ยกเลิก",
                        maxFileCount: 20,
                        maxFileSize: 20240000,
                        cancelStr:"ยกเลิก", 
                        multiDragErrorStr: "กรุณาอัปโหลดไฟล์",
                        uploadStr:"เลือกไฟล์",
                        multiple:true,
                        dragDrop:true,
                        returnType: "json",'
                . $showDelete . '
                        showDownload:true,
                        fileName:"' . @$config['id'] . '",
                        onLoad:function(obj){ ';
        if (@$config['show_list_file'] == true || !isset($config['show_list_file'])) {
            $js .= '  $.ajax({
                                          cache: false,
                                          url: "' . @$config['url_ajax'] . '?cmd=listfile",
                                          dataType: "json",
                                              success: function(data){
                                                      for(var i=0;i<data.length;i++){ 
                                                  obj.createProgress(data[i]["name"],data[i]["name_th"],data[i]["path"],data[i]["size"]);
                                             }
                                          }
                                 }); ';
        }
        $js .= '
                       },
                       deleteCallback: function (data, pd) {
                        for (var i = 0; i < data.length; i++) {
                            $.post("' . @$config['url_ajax'] . '?cmd=delete&is_tmp=1", {op: "delete",name: data[i]},
                                function (resp,textStatus, jqXHR) {
                                    
                                  /*alert("File Deleted"); */
                                });
                        }
                             pd.statusbar.hide(); 
                        },
                        downloadCallback:function(filename,pd)
                        {
                            
                               window.open("' . @$config['url_ajax'] . '?cmd=View&is_tmp=1&file_store_code=' . $file_store_code . '&filename="+filename,"_blank");
                                 
                        }
                    });';
        if (isset($config['show_upload_file'])) {
            if ($config['show_upload_file'] == false) {
                $js .= ' $("#upload_file").hide();  ';
            }
        }

        $js .= '
                 });
             ';
        $CI = &get_instance();
        //   $js = $ci->webutils->Minifier_script($js);
        echo $CI->ugly->js($js) . "\n\r\n\r\n\r ";
        // echo $js;
    }

}

if (!function_exists('generate_upload_file_list')) {

    function generate_upload_file_list($resource_code) {
        if (@$resource_code != '') {
            $ci = &get_instance();
            $ci->load->model('filestore/File_store_Model', 'file_store_Model');
            $file_list = $ci->file_store_Model->get_WithField("FILE_STORE_CODE", $resource_code);
            //var_dump($file_list);
            //exit(); 
            $data['list_file'] = $file_list;
            $data['show_file_upload'] = "";
            $data['page'] = '/modal/list_file_modal';
            echo $ci->load->view("module/filestore/list_file", $data, true);
        }
    }

}




if (!function_exists('profile_upload')) {

    function profile_upload($config = array()) {
        $current_img = @$config['current_img'];
        $img_src = '';
        // echo 'xxxx='.$current_img;
        if (isset($current_img)) {
            $output_file = site_url($current_img);
            //echo $output_file;
            if (file_exists($current_img)) {
                $img_src = 'src="' . $output_file . '"';
            }
        }
        $html = ' <div  style="height: 100px;width: 120px;">
                    <div class="circle">
                      <!-- User Profile Image -->
                      <img class="profile-pic rounded-circle" ' . $img_src . '>

                      <!-- Default Image -->
                      <!-- <i class="fa fa-user fa-5x"></i> -->
                    </div>
                    <div class="p-image">
                      <i class="fa fa-camera upload-button"  title="คลิ๊กที่นี่เพื่ออัปโหลดรูป"></i>
                       <input class="file-upload" type="file" id="img_profile" accept="image/*"/>
                    </div>
                 </div> ';

        $html .= '<script> $(document).ready(function() {
 
                        var readURL = function(input) {
                            if (input.files && input.files[0]) {
                                var reader = new FileReader();

                                reader.onload = function (e) {
                                    $(\'.profile-pic\').attr(\'src\', e.target.result);
                                    
                                    console.log(reader.result);
                                    
                                    _httpPostJson("' . @$config['url_upload'] . '",\'{"image_data":"\' +  reader.result +\'"}\');

                                }

                                reader.readAsDataURL(input.files[0]); 
                            }
                        }


                        $(".file-upload").on(\'change\', function(){
                            readURL(this);
                        });

                        $(".upload-button").on(\'click\', function() {
                           $(".file-upload").click();
                        });
                    });  </script>';
        return $html;
    }

}
?>
