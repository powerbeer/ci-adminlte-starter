<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {

    private $data;
    private $title = "ข้อมูลพนักงาน";
    private $module_path = "user";
    private $url_main = "Staff";
    private $authen;
    private $config_upload;
    private $search_text;
    private $list_column_search = array('user_id', "fullname", "username","email","mobile_phone");
    private $arr_validators_field = array(
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

        $this->config_upload = array(
            "id" => "upload_file",
            "show_delete" => true,
            "show_upload_file" => true,
            "upload_path_tmp" => $this->ioutils->getFolderTmpResource(),
            "upload_path" => $this->ioutils->getFolderResource('user'),
            "url_ajax" => site_url($this->url_main) . '/upload_file');

        /* config menu */
    }

    public function list($pageno = "1", $order_by = "1", $order_type = "asc") {

        $config_search = array(
            "class_name" => $this->router->class,
            'key_check' => '',
            "url_reset" =>'',
            "ar_param_search" => '',
            "sql_app_ar" =>'', //sql ad array
        );

        $this->searchUtils->config($config_search);
        $this->sql_app = $this->searchUtils->get_sqlString();

        $this->search_text = @$this->input->post('search_text');
      //  var_dump($this->search_text);exit();
        if (!empty($this->search_text)) {
            $this->searchUtils->set_search_text($this->search_text);
        } else if ($this->input->post()) {
            $this->searchUtils->clearSearchText();
        }

        $this->sql_search = $this->searchUtils->MakeSQLSearch($this->list_column_search);

        $this->data['search_text'] = $this->searchUtils->getSearchText();

        //var_dump($this->sql_search);
      //  exit();
        $sql_addon = $this->sql_search ;

        $datatable = $this->user_Model->list_table($sql_addon, $pageno, $order_by, $order_type);
        $page_nav_view = $this->datatable_utils->createNavPage(site_url($this->url_main . '/list'), $datatable, $order_by, $order_type);

        $this->data['page_nav_view'] = $page_nav_view;
        $this->data['datatable'] = $datatable;
        $this->data['page'] = $this->module_path . '/list/list_user';
        $this->load->view(TEMPLATE_PAGE, $this->data);
    }

    public function update($cmd_type, $id = "") {
        $postData = $this->input->post();
        //   var_dump($postData);exit();
        $modal_id = @$this->input->get('modal_id');

        $fullname = @$postData['fullname'];
        $user_group_id = @$postData['user_group_id'];
        $mobile_phone = @$postData['mobile_phone'];
        $email = @$postData['email'];


        $result_store = $this->upload_utils->Store_Session_tofile($this->config_upload);
        $file_store_code = $result_store['file_store_code'];


        if ($cmd_type == CMD_CREATE) {

            $data_create = array(
                "fullname" => $fullname,
                "file_store_code" => $file_store_code,
                "username" => $postData['username'],
                "user_group_id" => $user_group_id,
                "password_hash" => password_hash($postData['password'], PASSWORD_DEFAULT),
                "email" => $email,
                "mobile_phone" => $mobile_phone
            );

            $json_ret = $this->user_Model->Create($data_create);
        } else if ($cmd_type == CMD_UPDATE) {
            $data_update = array(
                "fullname" => $fullname,
                "user_group_id" => $user_group_id,
                "email" => $email,
                "mobile_phone" => $mobile_phone
            );
            if (!empty($file_store_code)) {
                $data_update['file_store_code'] = $file_store_code;
            }
            $json_ret = $this->user_Model->update($id, $data_update);
        } else if ($cmd_type == CMD_DELETE) {
            $json_ret = $this->user_Model->delete($id);
        }

        if ($json_ret[MASSAGE_STATUS] == STATUS_SUCCESS) {

            //กรณี success ให้ เพิ่ม param return
            $json_ret['modal_id'] = $modal_id;
            $json_ret['location_reload'] = true;
        }

        echo json_encode($json_ret);
    }

    public function form_modal($cmd_type, $id = "") {
        //init param
        $user_group_id = "";
        $config_user_group = array(
            "id" => "user_group_id",
            "name" => "user_group_id",
            "table" => "tbl_user_group",
            "desc" => "user_group_desc"
        );


        $file_store_code = "";
        if ($cmd_type == CMD_UPDATE) {
            $data_search = array("user_id" => $id);
            $detail = $this->user_Model->get_one_row_where($data_search);
            $row = $detail->row_array();
            $user_group_id = $row['user_group_id'];
            $file_store_code = $row['file_store_code'];
            $this->data['detail'] = $row;
        }

        $this->upload_utils->create_session($file_store_code);



        $this->data['config_upload'] = $this->config_upload;
        $this->data['upload_file_div'] = $this->upload_utils->gen_html($this->config_upload);

        $this->data['cmd_type'] = $cmd_type;
        $this->data['select2_user_group'] = $this->select2utils->create_select2($config_user_group, $user_group_id);
        $this->data['arr_validators_field'] = $this->arr_validators_field;
        $this->data['url_post'] = $this->url_main . '/update/' . $cmd_type . '/' . $id;
        $this->data['page'] = $this->module_path . '/modal/user_modal';
        $this->load->view(TEMPLATE_PAGE_BLANK, $this->data);
    }

    public function upload_file() {
        $cmd = $this->input->get('cmd');
        if ($cmd == "upload") {
            $upload = $this->upload_utils->Upload($this->config_upload);
            echo $upload;
        } else if ($cmd == "delete") {
            echo $this->upload_utils->Delete($this->config_upload);
        } else if ($cmd == 'View') {
            echo $this->upload_utils->Download($this->config_upload);
        } else if ($cmd == 'listfile') {
            $file_store_code = $this->upload_utils->getFileStoreCode();
            echo $this->upload_utils->getStoreFileSessionList($this->config_upload);
        } else if ($cmd == "listfilesession") {
            $file_list = $this->upload_utils->getStoreFileSessionList($this->config_upload);
            echo $file_list;
        }
    }

}
