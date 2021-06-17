<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class WebUtils {

    protected $CI;
    protected $folder_resource = "";
    protected $root_path = "";

    function __construct() {
        $this->CI = & get_instance();
        // $this->root_path=FCPATH;
    }

    public function CheckSessionEmpty($session_id, $session_name = "mysession") {

        $session_data = $this->CI->session->userdata($session_name);
        if (!empty($session_data[$session_id])) {
            return $session_data;
        } else {
            return null;
        }
    }

    public function check_valid_password($password_ = '') {
        $verify = array('valid' => true, 'valid_message' => 'ถูกต้อง');
        $password = trim($password_);
        $regex_lowercase = '/[a-z]/';
        $regex_uppercase = '/[A-Z]/';
        $regex_number = '/[0-9]/';
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';

        if (empty($password)) {
            $verify = array('valid' => false, 'valid_message' => 'กรุณากรอกข้อมูล');
            return $verify;
        }
        /*
          if (preg_match_all($regex_lowercase, $password) < 1) {
          $verify = array('valid' => false, 'valid_message' => 'จะต้องมีอักษรตัวพิมพ์เล็กอย่างน้อยหนึ่งตัว');
          return $verify;
          }

          if (preg_match_all($regex_uppercase, $password) < 1) {
          $verify = array('valid' => false, 'valid_message' => 'ต้องเป็นตัวพิมพ์ใหญ่อย่างน้อยหนึ่งตัว');
          return $verify;
          }

         */
        if (preg_match_all($regex_number, $password) < 1) {
            $verify = array('valid' => false, 'valid_message' => 'ต้องมีตัวเลขอย่างน้อยหนึ่งหมายเลข');
            return $verify;
        }
        /*
          if (preg_match_all($regex_special, $password) < 1) {
          $verify = array('valid' => false, 'valid_message' => 'ต้องมีอักขระพิเศษอย่างน้อยหนึ่งอักขระ เช่น .' . ' ' . htmlentities('!@#$%^&*()\-_=+{};:,<.>§~'));
          return $verify;
          }

         */

        if (strlen($password) < 5) {
            $this->form_validation->set_message('valid_password', '{field} ต้องมีความยาวอย่างน้อย 5 อักขระ');
            $verify = array('valid' => false, 'valid_message' => 'ต้องมีความยาวอย่างน้อย 5 อักขระ');
            return $verify;
        }

        return $verify;
    }

    public function randomCode($length = 10) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    public function Year2Thai() {
        return (int) date("y") + 43;
    }

    public function password_hash($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function password_hash_check($str_check, $password_hash_check) {
        return password_verify($str_check, $password_hash_check);
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
        $this->folder_resource = $this->CI->session->folder_resource;
        //echo 'profile_id='.$this->CI->session->profile_id;

        $user_path_data = $this->root_path . "userdata" . DIRECTORY_SEPARATOR . $this->folder_resource . DIRECTORY_SEPARATOR . $this->CI->session->profile_id;
        if (!is_dir($user_path_data)) {
            
        }

        if ($folder_name != '') {
            $user_path_data .= DIRECTORY_SEPARATOR . $folder_name;
        }
        return $user_path_data;
    }

    public function moveResource($image_file, $old_image_file, $resource_folder, $key_id, $new_keyid, $data_form, $cmd) {

        if ($image_file != '') {

            $source_file = $this->getFolderResource("temp") . DIRECTORY_SEPARATOR . 'tmp_' . $image_file;
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

    public function JsonMessage($status, $message = "", $addon = null) {

        $message = array(
            "status" => $status,
            "message" => "$message"
        );

        if (is_array($addon)) {
            $message = array_merge($addon, $message);
        }
        return $message;
    }
 
}
