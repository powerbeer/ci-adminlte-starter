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
        $this->load->model('user/User_Model', 'user_Model');
        $this->load->library('Select2Utils', null, "select2utils");
        $this->data = array();
        $this->init();
    }

    private function init() {
        $this->authen = $this->session->userdata(SESSION_AUTHEN);
        $this->data['title'] = $this->title;
        $this->data['url_main'] = $this->url_main;
    }

    public function list($pageno = "1", $order_by = "1", $order_type = "asc") {
        $sql_addon = "";

        $datatable = $this->user_Model->list_table($sql_addon, $pageno, $order_by, $order_type);
        $page_nav_view = $this->datatable_utils->createNavPage(site_url($this->url_main . '/list'), $datatable, $order_by, $order_type);

        $this->data['page_nav_view'] = $page_nav_view;
        $this->data['datatable'] = $datatable;
        $this->data['page'] = $this->module_path . '/list/list_user';
        $this->load->view(TEMPLATE_PAGE, $this->data);
    }

    public function update($id = "") {
        $postData = $this->input->post();
        //   var_dump($postData);exit();
        $modal_id = @$this->input->get('modal_id');
        $cmd_type = @$this->input->post('cmd_type');
    }

    public function form_modal($cmd_type, $id = "") {

        $arr_validators_field = array(
            array("fields" =>
                "fullname", "validators" => array(array("notEmpty", "กรุณากรอก"))
            ),
            array("fields" =>
                "email", "validators" => array(array("notEmpty", "กรุณากรอก"))
            ),
            array("fields" =>
                "username", "validators" => array(array("notEmpty", "กรุณากรอก"))
            ),
            array("fields" =>
                "password", "validators" => array(array("notEmpty", "กรุณากรอก"))
            )
        );

        $user_group_id = "";
        $config_user_group = array("id" => "user_group_id", "name" => "user_group_id", "table" => "tbl_user_group", "desc" => "user_group_desc");


        if ($cmd_type == CMD_UPDATE) {
            $data_search = array("user_id" => $id);
            $detail = $this->user_Model->get_one_row_where($data_search);
            $this->data['detail'] = $detail->row_array();
        }

        $this->data['cmd_type'] = $cmd_type;
        $this->data['select2_user_group'] = $this->select2utils->create_select2($config_user_group, 1);
        $this->data['arr_validators_field'] = $arr_validators_field;
        $this->data['url_post'] = $this->url_main . '/update/' . $id;
        $this->data['page'] = $this->module_path . '/modal/user_modal';
        $this->load->view(TEMPLATE_PAGE_BLANK, $this->data);
    }

}
