<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authen_session {

    protected $CI;
    protected $log_type = "LOGIN";

    function __construct() {
        $this->CI = & get_instance();
    }

    public function check_user($username, $password, $config = array()) {
        //check user and password
        $login_type = @$config['login_type'];
        if (empty($login_type)) {
            $login_type = "session";
        }
        $this->CI->load->model('user/User_Model', 'user_Model');

        $data_where = array(
            'username' => $username,
        );
        $query = $this->CI->User_Model->get_one_row_where($data_where);

        if ($query->num_rows() == 1) {
            $row = $query->row();
            $password_db = $row->password_hash;
            if (password_verify($password, $password_db)) {

                $user_id = $row->user_id;

                $user_data = array(
                    SESSION_AUTHEN => $row
                );

                // var_dump($user_data);
                // exit();
                $create_token_key = $this->CI->web_utils->randomCode(20);

                if ($login_type == 'session') {
                    $this->CI->session->set_userdata($user_data);  //create session data!!!!
                    //ตรวจสอบข้อมูลเบื้องต้น get ค่าเบื้องต้น
                    $addon_json = array("url_redirect" => "Dashboard/welcome", "token_key" => $create_token_key);
                } else if ($login_type == 'api') {
                    
                }

                $this->CI->web_utils->createFolder();  //create defalte folder
                return json_encode($this->CI->web_utils->JsonMessage(STATUS_SUCCESS, "เข้าระบบเรียบร้อย", $addon_json));
            } else {
                //$this->data['page'] = "member/login";
                return json_encode($this->CI->web_utils->JsonMessage(STATUS_ERROR, "รหัสผ่านไม่ถูกต้อง กรุณาตรวจสอบการกรอก"));
                //  echo json_encode($query);
            }
        } else {
            return json_encode($this->CI->web_utils->JsonMessage(STATUS_ERROR, "ไม่พบข้อมูลผู้ใช้งาน กรุณาตรวจสอบ"));
        }
    }

}

?>
