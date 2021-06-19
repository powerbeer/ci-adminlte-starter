<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class IOUtils {

    protected $CI;
    protected $folder_resource = ""; 
    protected $folder_tmp_resource = "";
    protected $root_path = "";

    function __construct() {
        $this->CI = & get_instance();
        // $this->root_path=FCPATH;
    }
    
    public function CheckSessionEmpty($session_name){
        
        if($this->CI->session->userdata($session_name)==''){
            return false;
        }else{
            return true;
        }
    }

    public function createFolder($folder_name = "") {

        $this->folder_resource = $this->CI->session->folder_resource;

        $user_path_data = $this->root_path . "userdata" . DIRECTORY_SEPARATOR . $this->folder_resource;
        if (!is_dir($user_path_data)) {
            mkdir($user_path_data, 0755, TRUE);
        }

        if ($folder_name != '') {
            $user_path_data .= DIRECTORY_SEPARATOR . $this->CI->session->profile_id . DIRECTORY_SEPARATOR . $folder_name;
            //  var_dump($user_path_data);
            if (!is_dir($user_path_data)) {
                mkdir($user_path_data, 0755, TRUE);
            }
        }
    }

    public function getFolderResource($folder_name = "") {  //ดึง url เท่านั้น
        $this->folder_resource = $this->CI->session->userdata(SESSION_FOLDER_RESOURCE);
        
        if(@$this->folder_resource==''){
          echo 'not permission to io';
          exit();
        }

        //echo 'profile_id='.$this->CI->session->profile_id;

        $user_path_data = $this->root_path . "userdata" . DIRECTORY_SEPARATOR . $this->folder_resource ;
        if (!is_dir($user_path_data)) {
            
        }

        if (!empty($folder_name) ) {
            $user_path_data .= DIRECTORY_SEPARATOR . $folder_name;
        }
        return $user_path_data;
    }
    
     
    
    public function getFolderTmpResource($folder_name = "") {  //ดึง url เท่านั้น
        $this->folder_tmp_resource = $this->CI->session->userdata(SESSION_FOLDER_RESOURCE_TMP);
       

        if(@$this->folder_tmp_resource==''){
            $tmp_folder= 'userdata' .DIRECTORY_SEPARATOR.'tmp';
           
            return $tmp_folder;
        } 

        $user_path_data = $this->root_path . "userdata" . DIRECTORY_SEPARATOR . $this->folder_tmp_resource ; 

        if ($folder_name != '') {
            $user_path_data .= DIRECTORY_SEPARATOR . $folder_name;
        }
        return $user_path_data;
    }

    public function moveResource($image_file, $old_image_file, $resource_folder, $key_id, $new_keyid, $data_form,$cmd) {

        if ($image_file != '') {

            $source_file = $this->getFolderResource("tmp") . DIRECTORY_SEPARATOR . 'tmp_' . $image_file;
            // echo 'ource_file ='. $source_file;
            // echo FCPATH .'nnnnnnnn';
            // echo 'source_file =='. $source_file;
            $file_ex = file_exists($source_file);
            //echo 'file exist='.$file_ex;
            if ($file_ex) {
                $new_folder = $resource_folder . DIRECTORY_SEPARATOR . $new_keyid;
                //  echo 'dest_folder =='.$dest_folder;

                $dest_file = $this->getFolderResource() . DIRECTORY_SEPARATOR . $new_folder . DIRECTORY_SEPARATOR . $image_file;
                //echo 'dest_file ='.$dest_file;
                $this->createFolder($new_folder);

                $is_move_file = rename($source_file, $dest_file);
                // echo 'is_move_file='.$is_move_file;
                if ($is_move_file) {
                    $data_form['image_file'] = $image_file;

                    if ($old_image_file != '' && $key_id != '' && $cmd != CMD_CREATE) {
                        if ($old_image_file != $image_file) {
                            $unlink_file = $this->getFolderResource($resource_folder) . DIRECTORY_SEPARATOR . $key_id . DIRECTORY_SEPARATOR . $old_image_file;
                            //  echo $unlink_file;
                            ////  exit();
                            @unlink($unlink_file);
                        }
                    }
                }
            }                        
        }
        return $data_form;
    }
     
}
