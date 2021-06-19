<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Filestore_Model extends CI_Model {

    private $_table = "tbl_resource_file_store";
    private $pk = "file_store_code";
    private $status = "resource_status";

    public function get_detail($file_store_code) {
        $data_where = array(
            $this->pk => $file_store_code,
            $this->status . ' >=' => 1
        );
        
        $query = $this->db->get_where($this->_table, $data_where);
        //echo $this->db->last_query();
        if ($query->num_rows() == 1) {
            return $query;
        } else {
            return null;
        }
    }

    public function get_all($file_store_code) {
        $data_where = array(
            $this->pk => $file_store_code,
            $this->status . ' >=' => 1
        );
        $query = $this->db->get_where($this->_table, $data_where);
        //echo $this->db->last_query();
        return $query;
    }

    public function Create($file_store_code, $file_store_path, $file_name, $user_id, $file_name_th = "") {

        $data = array(
            "file_store_code" => $file_store_code,
            "file_store_path" => $file_store_path,
            "file_name" => $file_name,
            "file_name_th" => $file_name_th);
        $this->db->insert($this->_table, $data);
        // echo $this->db->last_query();

        if ($this->db->affected_rows() > 0) {
            $data['file_store_code'] = $file_store_code;
            $data['message'] = MESSAGE_CREATE_COMPLETE;
            $data['message_status'] = STATUS_SUCCESS;
            $data['status'] = true;
        } else {
            $data = array(
                'status' => false,
                'message_status' => STATUS_ERROR,
                'message' => MESSAGE_CREATE_ERROR
            );
        }

        return $data;
    }

    public function Remove($file_store_code, $file_name) {


        $data_where = array("file_name" => $file_name, "file_store_code" => $file_store_code);
        $data = array($this->status => 0);

        $this->db->update($this->_table, $data, $data_where);
        // echo $this->db->last_query();

        if ($this->db->affected_rows() > 0) {
            $data['message'] = MESSAGE_DELETE_COMPLETE;
            $data['message_status'] = STATUS_SUCCESS;
            $data['status'] = true;
        } else {
            $data = array(
                'status' => false,
                'message_status' => STATUS_ERROR,
                'message' => MESSAGE_DELETE_ERROR
            );
        }

        return $data;
    }

    public function getCount($sql_addon) {
        $sql = "SELECT  COUNT(*)  AS TOTAL_ROW
        FROM " . $this->_table . " a ";
        if ($sql_addon != '') {
            $sql .= " WHERE " . $sql_addon;
        }
        //  echo $sql;
        $query = $this->db->query($sql)->row();
        return $query->TOTAL_ROW;
    }

}

?>