<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class UploadUtils {

    private $CI;
    private $path_allow = array("userdata");
    private $file_ext_allow = array("jpg", "pdf", "jpeg");
    private $file_store_code;
    
    private $authen;
    private $staffid;
    private $session_code = "SESSION_CODE";
    private $root_path;

    function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('global/Filestore_Model', 'filestore_Model');
        $this->authen = $this->CI->session->userdata(SESSION_AUTHEN);
        $this->root_path=  FCPATH;
    }

    public function config($config) {
        $data = array();
        $data['upload_path'] = $config['upload_path'];
        if (isset($config['file_ext_allow'])) {
            $this->file_ext_allow = $config['file_ext_allow'];
        }
        return $data;
    }

    public function create_session($file_store_code = "", $session_code = "") {
        if (empty($file_store_code)) {
            $file_store_code = $this->CI->web_utils->randomCode(20);
        }

        if (empty($session_code)) {
            $session_code = $this->CI->web_utils->randomCode(20);
        }
        $user_data = array(SESSION_FILE_LIST => array(SESSION_FILE_STORE_CODE => $file_store_code), SESSION_FILE_LIST_DELETE => array());
        //  var_dump($user_data);exit();
        $this->CI->session->set_userdata($user_data);
        //return $user_data['']
    }

    public function getFileCount($file_store_code = "") {

        $file_list_store = (Array) $this->CI->session->userdata(SESSION_FILE_LIST);
        $file_list_store_delete = (Array) $this->CI->session->userdata(SESSION_FILE_LIST_DELETE);

        $total = count(@$file_list_store['FILE_LIST']) - count(@$file_list_store_delete);
        //echo $total;
        return $total;
    }

    public function getFileStoreCode() {
        $file_list_store = (Array) $this->CI->session->userdata(SESSION_FILE_LIST);
        $code = @$file_list_store[SESSION_FILE_STORE_CODE];
        //var_dump($code);
        return $code;
    }

    public function getStoreFileList() {
        $file_list_store = (Array) $this->CI->session->userdata(SESSION_FILE_LIST_STORE);
        // $file_list_store;
        return $file_list_store;
    }

    public function getStoreFileSessionList($config = array()) {
        $file_store_code = $this->getFileStoreCode();
        $file_list_store = (Array) $this->CI->session->userdata(SESSION_FILE_LIST);
        // $file_list_store;
        $file_list = @$file_list_store['FILE_LIST'];
        $file_list_delete = (Array) $this->CI->session->userdata(SESSION_FILE_LIST_DELETE);
        //     var_dump($file_list);
        //
        //    exit();
        $file_list_new = array();
        $ret = array();
        if (is_array($file_list)) {
            for ($i = 0; $i < count($file_list); $i++) {
                $is_delete = in_array($file_list[$i], $file_list_delete);
                //var_dump($is_delete);

                if ($is_delete == true) {
                    //  unset($file_list[$i]);
                } else {
                    $file_list_new[] = $file_list[$i];

                    $file_name = $file_list[$i];
                    $path = $config['upload_path_tmp'];
                    $filePath = $path . DIRECTORY_SEPARATOR . $file_name;
                    if (file_exists($filePath)) {
                        $details = array();
                        $details['name'] = $file_name;
                        $details['path'] = $path;
                        $details['full_path'] = $filePath;
                        $details['size'] = @filesize($filePath);
                        $ret[] = $details;
                    }
                }
            }
        }


        $list_database_store = $this->ListFile($file_store_code);
        $ret_ = array_merge($ret, json_decode($list_database_store, true));


        // var_dump($file_list_delete);
        // var_dump($file_list);
        return json_encode($ret_);
    }

    public function gen_html($config) {
        // $desc=$this->getValue($select_value);

        $html = '<div id="' . $config['id'] . '">แนบไฟล์</div><p class="required font-size-10">*ชนิดไฟล์ที่สามารถรองรับคือ ' . implode(",", $this->file_ext_allow) . ' เท่านั้น</p>';
        return $html;
    }

    public function ListFile($file_store_code = "") {

        $ret = array();
        $list_file_data = $this->CI->filestore_Model->get_all($file_store_code);

        //var_dump($list_file_data);
        //$dir = $config['upload_path'];
        if ($list_file_data->num_rows() > 0) {
            $i = 0;
            foreach ($list_file_data->result() as $row) {
                //  for ($i = 0; $i < count($list_file_data); $i++) {
                $file_name = $row->file_name;
                $file_name_th = $row->file_name_th;
                $path = $row->file_store_path;
                $filePath = $path . DIRECTORY_SEPARATOR . $file_name;
                $details = array();
                $details['name'] = $file_name;
                $details['name_th'] = $file_name_th;
                $details['path'] = $path;
                $details['full_path'] = $filePath;
                $details['size'] = @filesize( $filePath);
                $ret[] = $details;
            }
        } else {
            //$ret=$this->getStoreFileList();
        }


        return json_encode($ret);
    }

    public function Delete($config = array()) {
        
        $file_store_code=$this->getFileStoreCode();

        $file_list_delete = (Array) $this->CI->session->userdata(SESSION_FILE_LIST_DELETE);
      //var_dump($file_list_delete);

        $upload_path_tmp = $config['upload_path_tmp'];
        $output_dir_tmp = $upload_path_tmp . DIRECTORY_SEPARATOR;

        $upload_path = @$config['upload_path'];
        $output_dir = $upload_path . DIRECTORY_SEPARATOR .$file_store_code . DIRECTORY_SEPARATOR;


        $is_delete = false;
        //echo $output_dir;
        //exit();

        if (isset($_POST["op"]) && $_POST["op"] == "delete" && isset($_POST['name'])) {
            $fileName = $_POST['name'];
            $fileName = str_replace("..", ".", $fileName); //required. if somebody is trying parent folder files	
            $filePath = $output_dir . $fileName;
            $filePath_tmp = $output_dir_tmp . $fileName;

            $file_list_delete[] = $fileName;
            /*
             * หากต้องการลบจริงให้  uncomment 
            //var_dump($filePath);exit();
            if (file_exists($filePath)) {
                @unlink($filePath);
                $is_delete = true;
            } else if (file_exists($filePath_tmp)) {
                @unlink($filePath_tmp);
                $is_delete = true;
            }

            */
            $is_delete=true;
            if ($is_delete == true) {

                $user_data = array(SESSION_FILE_LIST_DELETE => $file_list_delete);
                $this->CI->session->set_userdata($user_data);

                $exec = $this->CI->filestore_Model->Remove($this->getFileStoreCode(), $fileName);
                if ($exec['message_status'] == STATUS_SUCCESS) {
                    return "Deleted File Complete : " . $fileName . "<br>";
                } else {
                    return "Deleted ERROR!!! : " . $fileName . "<br>";
                }
            }
        }
    }

    public function Download($config = array()) {
        $is_tmp = @$_GET['is_tmp'];
        $file_store_code= @$this->CI->input->get('file_store_code');

        $upload_path_tmp = $config['upload_path_tmp'];

        $upload_path = $config['upload_path'];

        //   var_dump($upload_path);
        //  exit();

        if (isset($_GET['filename'])) {
            $fileName = $_GET['filename'];
            $fileName = str_replace("..", ".", $fileName); //required. if somebody is trying parent folder files

            $file_tmp = $upload_path_tmp . DIRECTORY_SEPARATOR . $fileName;
            $file = $upload_path . DIRECTORY_SEPARATOR .$file_store_code.DIRECTORY_SEPARATOR. $fileName;
           // var_dump($file);exit();
            $file = str_replace("..", "", $file);
            $file_tmp = str_replace("..", "", $file_tmp);

            // var_dump($file_tmp);
            // exit();

            if (file_exists($file)) {
                
            } else if (file_exists($file_tmp)) {
                $file = $file_tmp;
            }

            $file_path_encode = $this->CI->web_utils->encrypt($file);

            // exit();
            //  $fileName = str_replace(" ", "", $fileName);
            //echo 'xxx';
            //exit();

            return $this->viewer($file_path_encode);

            /*

              //  header('Content-Description: File Transfer');
              header('Content-Disposition: attachment; filename=' . $fileName);
              header('Content-Transfer-Encoding: binary');
              header('Expires: 0');
              header('Cache-Control: must-revalidate');
              header('Pragma: public');
              header('Content-Length: ' . filesize($file));
              ob_clean();
              flush();
              readfile($file);
             * 
             */
            exit;
        }
    }

    public function Store_Session_tofile($config = null) {
        $output_dir_tmp = $config['upload_path_tmp'] . DIRECTORY_SEPARATOR;
        $output_dir = $config['upload_path'] . DIRECTORY_SEPARATOR;
        $list_file_ = $this->CI->session->userdata(SESSION_FILE_LIST);

        $file_store_code = $list_file_[SESSION_FILE_STORE_CODE];
        $file_list_store_delete = (Array) @$this->CI->session->userdata(SESSION_FILE_LIST_DELETE);

        $list_file = @$list_file_['FILE_LIST'];
        $list_file_th = @$list_file_['FILE_LIST_TH'];
        //    var_dump($list_file);
        //
        //exit();
        $upload_complete = 0;
        $upload_fail = 0;
        if (isset($list_file)) {
            $ret = array();
            $ret['file_store_code'] = $file_store_code;
            for ($i = 0; $i < count($list_file); $i++) {
                $fileName = $list_file[$i];

                if (in_array($fileName, $file_list_store_delete)) {
                    continue;
                }
 
                $fullPath_tmp = $output_dir_tmp . $fileName;

                if (file_exists($fullPath_tmp)) {
                    $filepath = $output_dir . $file_store_code ;
                    $fullPath = $filepath .DIRECTORY_SEPARATOR. $fileName;
                    //var_dump($filepath);exit();
                    if (!is_dir($filepath)) {
                        mkdir($filepath, 0777, true);
                    }
 
                    rename($fullPath_tmp, $fullPath);
                    if (file_exists($fullPath)) {
                        $fileName_th = @$list_file_th[$i];

                        $exec = $this->CI->filestore_Model->Create($file_store_code, $filepath, $fileName, $this->staffid, $fileName_th);
                        $detail = array();
                        $detail['fileName'] = $fileName;
                        $detail['statusStore'] = $exec['message_status'];
                        if ($exec['message_status'] == STATUS_SUCCESS) {
                            $upload_complete++;
                        } else {
                            $upload_fail++;
                        }
                        $detail['upload_complete_total'] = $upload_complete;
                        $detail['upload_fail_total'] = $upload_fail;

                        $ret[] = $detail;
                    }
                }
            }

            return $ret;
        }
    }

    public function Upload($config = array()) {

        if (isset($config['file_ext_allow'])) {
            $this->file_ext_allow = $config['file_ext_allow'];
        }
        $this->file_store_code = $this->CI->session->userdata(SESSION_FILE_STORE_CODE);
        $list_file = $this->CI->session->userdata(SESSION_FILE_LIST);
        if (!isset($list_file)) {
            $list_file = array();
        }
        $output_dir = $config['upload_path_tmp'] . DIRECTORY_SEPARATOR;
        // $list_file['DIR_UPLOAD'][]=$output_dir;
        //  var_dump($_FILES);
        //   exit();
        if (isset($_FILES[$config['id']])) {
            $ret = array();
//	This is for custom errors;	
            /* 	$custom_error= array();
              $custom_error['jquery-upload-file-error']="File already exists";
              echo json_encode($custom_error);
              die();
             */
            $error = $_FILES[$config['id']]["error"];
            if ($error != null) {
                return json_encode($error);
            }
            //You need to handle  both cases
            //If Any browser does not support serializing of multiple files using FormData() 
            if (!is_array($_FILES[$config['id']]["name"])) { //single file
                // echo 'eeeeeeeeeeeee';
                $fileName = $_FILES[$config['id']]["name"];
                $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                if (in_array($ext, $this->file_ext_allow)) {
                    $new_fileName = $this->CI->web_utils->randomCode(25) . '.' . $ext;
                    move_uploaded_file($_FILES[$config['id']]["tmp_name"], $output_dir . $new_fileName);
                    $ret[] = $new_fileName;
                    $list_file['FILE_LIST'][] = $new_fileName;
                    $list_file['FILE_LIST_TH'][] = $fileName;
                    // echo 
                } else {
                    // echo 'xxxx';
                    $custom_error = array();
                    $custom_error['jquery-upload-file-error'] = "ชนิดไฟล์ไม่ถูกต้อง";
                    return json_encode($custom_error);
                    //die();
                }
            } else {  //Multiple files, file[]
                $fileCount = count($_FILES[$config['id']]["name"]);
                // echo 'rrrrrrrrrrrr';
                for ($i = 0; $i < $fileCount; $i++) {
                    $fileName = $_FILES[$config['id']]["name"][$i];
                    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    if (in_array($ext, $this->file_ext_allow)) {
                        $new_fileName = $this->CI->web_utils->randomCode(25) . '.' . $ext;
                        move_uploaded_file($_FILES[$config['id']]["tmp_name"][$i], $output_dir . $new_fileName);
                        $ret[] = $new_fileName;
                        $list_file['FILE_LIST'][] = $new_fileName;
                    } else {
                        $custom_error = array();
                        $custom_error['jquery-upload-file-error'] = "ชนิดไฟล์ไม่ถูกต้อง";
                        return json_encode($custom_error);
                        //die();
                    }
                }
            }
            // var_dump($list_file);
            $user_data = array(SESSION_FILE_LIST => $list_file);
            $this->CI->session->set_userdata($user_data);
            return json_encode($ret);
        } else {
            $custom_error['jquery-upload-file-error'] = "error!..";
            return json_encode($custom_error);
        }
    }

    public function viewer($file_url) {

        $is_tmp = $this->CI->input->get('is_tmp');
        
        $file_path = site_url($this->CI->web_utils->decrypt($file_url));
        //  var_dump($file_path);
        //    exit();

        $html = "<!DOCTYPE html>
                <html lang=\"en\"><head><meta charset=\"UTF-8\" /></head><body>
                <script src='" . base_url() . "/assets/plugins/pdfobject/pdfobject.js'></script>
                    <script>
                        var options = {
                            pdfOpenParams: {view: 'Fit', pagemode: 'thumbs', scrollbar: '1', toolbar: '1', statusbar: '1'}
                        };

                        PDFObject.embed(\"" . $file_path . "\", false, options);
                    </script>";


        $html .= '<div id="pdfRenderer"></div>  '
                . '</body></html>';



        return $html;
    }

}
