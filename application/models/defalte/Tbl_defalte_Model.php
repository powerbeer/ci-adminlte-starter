<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_defalte_Model extends CI_Model {

    public $CI;
    public $db_conn;
    public $config_model = array(); 
    private $field_allow;

    function __construct() {
        $this->CI = & get_instance();
        parent::__construct();
        $this->db_conn = $this->db;
    }

   
    public function config($config_ = array()) {
        /*
         * field_allow= array("field1","field2");
         * select_sql="a1,b2,b2,b4,(select h from f )as cc"
         * field_datatable=""
         * table_name_view =table view
         * table_name =table real
         * profile_id=profile user id
         * primary_key= key id
         * field_status= key status of table data
         * db_user = userdatabase name,
         * order_by
         *
         */

        $this->config_model = $config_;
        if (isset($this->config_model['db_user'])) {
            $this->db_conn = $this->CI->load->database($this->config_model['db_user'], TRUE);
        }
        if (isset($this->config_model['field_allow'])) {
            $this->field_allow = $this->config_model['field_allow'];
        }
    }
 

    public function query($sql) {

        $query = $this->db_conn->query($sql);
        // echo $this->db->last_query();
        return $query;
    }

    public function get_one_row_query($sql) {

        $this->db_conn->limit(1);
        $query = $this->db_conn->query($sql);
        //  echo $this->db_conn->last_query();
        return $query;
    }

    public function get_all() {

        $query = $this->db_conn->get($this->config_model['table_name']);
        //  echo $this->db_conn->last_query();
        return $query;
    }

    public function get_where($data_search) {

        $query = $this->db_conn->get_where($this->config_model['table_name'], $data_search);
        //  echo $this->db_conn->last_query();
        return $query;
    }

    public function get_one_row_where($data_search) {

        $this->db_conn->limit(1);
        $query = $this->db_conn->get_where($this->config_model['table_name'], $data_search);
        //  echo $this->db_conn->last_query();
        return $query;
    }

    public function get_with_field($field, $value) {

        if (is_array($this->field_allow)) {
            if (!in_array($field, $this->field_allow)) {
                return null;
            }
            $data_where = array(
                $field => $value
            );


            if (isset($this->config_model['order_by'])) {

                if (is_array($this->config_model['order_by'])) {

                    for ($i = 0; $i < count($this->config_model['order_by']); $i++) {
                        $order_by = $this->config_model['order_by'][$i];
                        $this->db_conn->order_by($order_by);
                    }
                }
            }

            if (isset($this->config_model['field_status'])) {

                $data_where_ = array(
                    $this->config_model['field_status'] . '>=' => 1
                );

                $data_where = array_merge($data_where, $data_where_);
            }

            $query = $this->db_conn->get_where($this->config_model['table_name'], $data_where);

            if ($query->num_rows() == 0) {
                return null;
            }

            return $query;
        } else {
            return null;
        }
    }

    public function get_one_row_with_field($field, $value) {

        if (is_array($this->field_allow)) {
            if (!in_array($field, $this->field_allow)) {
                return null;
            }
            $data_where = array(
                $field => $value
            );

            if (isset($this->config_model['field_status'])) {

                $data_where_ = array(
                    $this->config_model['field_status'] . '>=' => 1
                );

                $data_where = array_merge($data_where, $data_where_);
            }

            $this->db_conn->limit(1);
            $query = $this->db_conn->get_where($this->config_model['table_name'], $data_where);

            if ($query->num_rows() == 0) {
                return null;
            }

            return $query->row_array();
        } else {
            return null;
        }
    }

    public function create($data) {
        //set date ////

        $data['create_date'] = date('Y-m-d H:i:s');
        $data['update_date'] = date('Y-m-d H:i:s');
        $this->db_conn->insert($this->config_model['table_name'], $data);

        $data_ret = array();
        $data_ret['param'] = $data;
        if ($this->db_conn->affected_rows() > 0) {

            $data_ret['message'] = MESSAGE_CREATE_COMPLETE;
            $data_ret['message_status'] = STATUS_SUCCESS;
            $data_ret['status'] = true;
        } else {
            $data_ret = array(
                'status' => false,
                'message_status' => STATUS_ERROR,
                'message' => MESSAGE_CREATE_ERROR
            );
        }

        return $data_ret;
    }

    public function update($id, $data) {

        $data['update_date'] = date('Y-m-d H:i:s');
        $data_where = array($this->config_model['primary_key'] => $id);

        $this->db_conn->update($this->config_model['table_name'], $data, $data_where);
        // echo $this->db_conn->last_query();

        $data_ret = array();
        $data_ret['param'] = $data;
        if ($this->db_conn->affected_rows() > 0) {

            $data_ret['message'] = MESSAGE_UPDATE_COMPLETE;
            $data_ret['message_status'] = STATUS_SUCCESS;
            $data_ret['status'] = true;
        } else {
            $data_ret = array(
                'status' => false,
                'message_status' => STATUS_ERROR,
                'message' => MESSAGE_UPDATE_ERROR
            );
        }

        return $data_ret;
    }

    public function update_where($data, $data_where) {

        $data['update_date'] = date('Y-m-d H:i:s');

        $this->db_conn->update($this->config_model['table_name'], $data, $data_where);
        // echo $this->db_conn->last_query();
        $data_ret = array();
        $data_ret['param'] = $data;
        if ($this->db_conn->affected_rows() > 0) {

            $data_ret['message'] = MESSAGE_UPDATE_COMPLETE;
            $data_ret['message_status'] = STATUS_SUCCESS;
            $data_ret['status'] = true;
        } else {
            $data_ret = array(
                'status' => false,
                'message_status' => STATUS_ERROR,
                'message' => MESSAGE_UPDATE_ERROR
            );
        }

        return $data_ret;
    }

    public function merge($data) {

        $this->db_conn->replace($this->config_model['table_name'], $data);
        // echo $this->db_conn->last_query();

        $data_ret = array();
        $data_ret['param'] = $data;
        if ($this->db_conn->affected_rows() > 0) {

            $data_ret['message'] = MESSAGE_UPDATE_COMPLETE;
            $data_ret['message_status'] = STATUS_SUCCESS;
            $data_ret['status'] = true;
        } else {
            $data_ret = array(
                'status' => false,
                'message_status' => STATUS_ERROR,
                'message' => MESSAGE_UPDATE_ERROR
            );
        }

        return $data_ret;
    }

    public function delete($id, $data_where_ = array()) {

        $data_where = array($this->config_model['primary_key'] => $id);
        $data_where = array_merge($data_where, $data_where_);
        $data = array($this->config_model['field_status'] => 0);
        $data['update_date'] = date('Y-m-d H:i:s');

        $this->db_conn->update($this->config_model['table_name'], $data, $data_where);
        // echo $this->db_conn->last_query();

        $data_ret = array();
        $data_ret['param'] = $data_where_;
        if ($this->db_conn->affected_rows() > 0) {

            $data_ret['message'] = MESSAGE_DELETE_COMPLETE;
            $data_ret['message_status'] = STATUS_SUCCESS;
            $data_ret['status'] = true;
        } else {
            $data_ret = array(
                'status' => false,
                'message_status' => STATUS_ERROR,
                'message' => MESSAGE_DELETE_ERROR
            );
        }

        return $data_ret;
    }

    public function get_count_by_field($field, $value) {

        $data_where = array($field => $value, $this->config_model['field_status'] . ">=" => 1);
        if (isset($this->config_model['profile_id'])) {
            $data_where['profile_id'] = $this->config_model['profile_id'];
        }

        $query = $this->db_conn->get_where($this->config_model['table_name'], $data_where);
        //echo $this->db->last_query();
        return $query->num_rows();
    }

    public function get_count($sql_addon) {
        $sql = "SELECT  COUNT(1)  AS TOTAL_ROW
        FROM " . $this->config_model['table_name'] . " a ";
        if ($sql_addon != '') {
            $sql .= " WHERE " . $sql_addon;

            if (isset($this->config_model['field_status'])) {

                $sql .= " AND " . $this->config_model['field_status'] . ">=1 ";
            }
        }
//          echo $sql;
        $query = $this->db_conn->query($sql)->row();
        return $query->total_row;
    }

    public function count_all() {
        $this->db_conn->from($this->config_model['table_name']);
        return $this->db_conn->count_all_results();
    }
    

    public function list_table($sql_addon, $pageno = "1", $order_by = "1", $order_type = "asc") {

        $sql_where = '';

        $prev_page = 1;
        $next_page = 3;
        if ($pageno > 1) {
            $prev_page = $pageno - 1;
        }

        $no_of_records_per_page = 10;
        $offset = ($pageno - 1) * $no_of_records_per_page;



        $sql_where = $this->config_model['field_status'] . '>0';

        if (trim($sql_addon) != '') {
            $sql_where .= "  and  " . $sql_addon . "   ";
        }


        $sql = "select count(1)as total from " . $this->config_model['table_name'] . '  a    where   ' . $sql_where;
        $query = $this->db_conn->query($sql)->row();
        $total_rows = $query->total;
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        if ($pageno < $total_pages) {
            $next_page = $pageno + 1;
        }

        $sql = "select " . $this->config_model['primary_key'] . ',' . $this->config_model['field_select'] . ',' . $this->config_model['field_status'] . ' from ' . $this->config_model['table_name'] . ' a ';

        $sql .= " where " . $sql_where;

        $sql .= " order by " . $order_by . '  ' . $order_type;

        $sql .= " LIMIT $offset, $no_of_records_per_page ";

        //echo $sql;

        $query = $this->db_conn->query($sql);
        
        
        $list_data = array(
            'total_rows' => $total_rows,
            'total_pages' => $total_pages,
            'no_of_records_per_page' => $no_of_records_per_page,
            'offset' => $offset,
            'current_page' => $pageno,
            'prev_page' => $prev_page,
            'next_page' => $next_page,
            'result' => $query->result()
        );

        return $list_data;
    }

    public function list_table_with_sql($sql, $pageno = "1", $no_of_records_per_page = 10, $order_by = "1", $asc = "asc") {

        $prev_page = 1;
        $next_page = 3;
        if ($pageno > 1) {
            $prev_page = $pageno - 1;
        }

        // $no_of_records_per_page = 10;
        $offset = ($pageno - 1) * $no_of_records_per_page;

        //  $sql="select count(1)as total from ".$this->config_model['table_name'];
        $query = $this->db_conn->query($sql);
        $total_rows = $query->num_rows();
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        if ($pageno < $total_pages) {
            $next_page = $pageno + 1;
        }

        //  $sql=


        $sql .= " order by " . $order_by . ' ' . $asc;
        $sql .= " LIMIT $offset, $no_of_records_per_page ";
        $query = $this->db_conn->query($sql);

        $list_data = array(
            'total_rows' => $total_rows,
            'total_pages' => $total_pages,
            'no_of_records_per_page' => $no_of_records_per_page,
            'offset' => $offset,
            'current_page' => $pageno,
            'prev_page' => $prev_page,
            'next_page' => $next_page,
            'datatable' => $query->result()
        );

        return $list_data;
    }

    public function last_query() {
        return $this->db_conn->last_query();
    }

}

?>