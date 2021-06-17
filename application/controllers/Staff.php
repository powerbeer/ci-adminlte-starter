<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {

    private $data;
    private $title = "ข้อมูลพนักงาน";
    private $module_path = "user";
    private $url_main = "Staff";
    private $authen;

    function __construct() {
        parent::__construct();

        $this->data = array();

        $this->init();
    }

    private function init() {

        $this->authen = $this->session->userdata(SESSION_AUTHEN);

        $this->data['title'] = $this->title;
        $this->data['url_main'] = $this->url_main;
    }

    public function list() {
        $this->data['page'] = $this->module_path . '/list/list_user';
        $this->load->view(TEMPLATE_PAGE_MODULE, $this->data);
    }

    public function form_modal() {
        $this->data['page'] = $this->module_path . '/modal/user_modal';
        $this->load->view(TEMPLATE_PAGE_MODULE, $this->data);
    }

}
