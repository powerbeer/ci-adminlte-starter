<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    private $data;
    private $title = "เข้าระบบ";
    private $module_path = "frontpage";
    private $url_main = "Login";

    function __construct() {
        parent::__construct();

        $this->load->library('Authen_session', null, "authen_session");

        $this->data = array();

        $this->init();
    }

    private function init() {
        $this->data['title'] = $this->title;
        $this->data['url_main'] = $this->url_main;
    }

    public function index() {

        $arr_validators_field = array(
            array("fields" =>
                "username", "validators" => array(array("notEmpty", "กรุณากรอก"))
            ),
            array("fields" =>
                "password", "validators" => array(array("notEmpty", "กรุณากรอก"))
            )
        );

        $this->data['url_post'] = $this->url_main . "/checkLogin";
        $this->data['arr_validators_field'] = $arr_validators_field;
        $this->data['page'] = $this->module_path . '/login';
        $this->load->view(TEMPLATE_PAGE_FRONTPAGE, $this->data);
    }

    public function checkLogin() {

        header('Content-Type: application/json');
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        if (!isset($request->username)) {
            echo json_encode($this->web_utils->JsonMessage(STATUS_ERROR, "กรุณากรอก Username"));
            return;
        } else if (!isset($request->password)) {
            echo json_encode($this->web_utils->JsonMessage(STATUS_ERROR, "กรุณากรอก รหัสผ่าน"));
            return;
        }

        echo $this->authen_session->check_user(@$request->username, @$request->password);
    }

}
