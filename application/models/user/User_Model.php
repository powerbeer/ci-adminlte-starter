<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_Model extends tbl_defalte_Model {

    private $_table = "tbl_user";   //table จริง 
    private $field_pk = "user_id";  // PK
    private $field_status = "user_status";  // field status
    private $field_allow = array("user_id","username");
    private $field_datatable="fullname,username,user_group_id,password_hash,email,mobile_phone";
    private $order_by="INSERT_DATE";

    function __construct() {
        parent::__construct();
        $this->_set_data_model();
    }

    private function _set_data_model() {
        $config_model = array(
            "field_allow" => $this->field_allow,
            "field_select" =>   $this->field_datatable .','.$this->field_pk .",".$this->field_status,
            "field_datatable" =>$this->field_datatable  ,
            "order_by" =>$this->order_by ."  ASC", 
            "table_name" => $this->_table,
            "primary_key" => $this->field_pk,
            "field_status" => $this->field_status
        );
        $this->config($config_model);
    }

}

?>