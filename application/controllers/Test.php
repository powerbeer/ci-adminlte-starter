<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

    public function test_template() {
        $this->load->view(TEMPLATE_PAGE_IFRAME);
    }

    public function create_defalte_user() {
        $this->load->model('user/User_Model', 'user_Model');

        $new_password = 'gank001';
        $data_update = array(
            'fullname' => 'admin ระบบ',
            'password_hash' => password_hash($new_password, PASSWORD_DEFAULT),
            'email' => 'powerbeer@gmail.com',
            'username' => 'powerbeer',
            'mobile_phone' => '0835356006'
        );

        $query = $this->user_Model->create($data_update);
    }

}
