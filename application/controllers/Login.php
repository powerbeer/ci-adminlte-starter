<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    private $data;
    private $title = "เข้าระบบ";
    private $module_path = "frontpage";
    private $url_main="Login";

    function __construct() {
        parent::__construct();
        $this->data = array();

        $this->init();
    }

    private function init() { 
        $this->data['title']=$this->title;
        $this->data['url_main']=$this->url_main; 
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
        
        $this->data['arr_validators_field']=$arr_validators_field;
        $this->data['page'] = $this->module_path.'/login';
        $this->load->view(TEMPLATE_PAGE_FRONTPAGE, $this->data);
    }

}
