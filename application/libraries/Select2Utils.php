<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Select2Utils {

    private $CI;
    private $db_resource;
    private $arr_field;
    /*
      private $arr_field;
      private $id;
      private $desc;
      private $table;
     * /
     */
    private $table_allow = array(
        "L_CATM",
        "L_PROVINCE",
        "L_DISTRICT",
        "L_SUBDISTRICT",
        "TBL_CUSTOMER_GROUP",
        "TBL_USER_GROUP"
    );

    function __construct() {
        $this->CI = & get_instance();
    }

    public function show_json($config) {
        $query = $this->get_lookup($config);
        echo json_encode($query->result());
    }

    public function get_lookup($config) {

        if ($this->db_resource == null) {
            $this->db_resource = $this->CI->db;
        }

        if (isset($config['table'])) {
            $config['table'] = $config['table'];
        }

        if (isset($config['link_id'])) {
            $config['LINK_ID'] = $config['link_id'];
        }

        if (isset($config['id'])) {
            $config['id'] = $config['id'];
        }

        if (isset($config['desc'])) {
            $config['desc'] = $config['desc'];
        }

        if (isset($config['text_search'])) {
            $config['text_search'] = $config['text_search'];
        }
        if (isset($config['where'])) {
            $config['where'] = $config['where'];
        }

        if (isset($config['order'])) {
            $config['order'] = $config['order'];
        }

        if (isset($config['order_by'])) {
            $config['order_by'] = $config['order_by'];
        }

        if (isset($config['table'])) {
            $config['table'] = $config['table'];
        }
        //      var_dump($config['table']);exit();
        if (!in_array(strtoupper($config['table']), $this->table_allow)) {
            echo '[]';
            exit();
        }

        $sql = 'SELECT ' . $config['id'] . ' AS "id",' . $config['desc'] . ' AS "desc" FROM ' . $config['table'];
        if (isset($config['where'])) {
            if ($config['where'] != '') {
                $sql .= " WHERE " . $config['where'];
            }
        }

        if (isset($config['text_search'])) {
            if (!isset($config['where']) || @$config['where'] == '') {
                $sql .= ' WHERE ';
            } else {
                $sql .= " AND ";
            }
            $sql .= "  ( " . $config['id'] . " LIKE '%" . $config['text_search'] . "%'";
            $sql .= "   OR  " . $config['desc'] . " LIKE '%" . $config['text_search'] . "%' ) ";
        }

        if (isset($config['order_by'])) {
            $sql .= ' ORDER BY ' . $config['order_by'] . ' ';
        }

        if (isset($config['order'])) {
            $sql .= $config['order'];
        }

        //  echo $sql;
        //exit();
        $query = $this->db_resource->query($sql);
        return $query;
    }

    private function getValue($config, $select_value = "") {
        $value = "";
        if ($select_value != '') {
            $sql = "select " . $config['desc'] . " as dsc from " . $config['table'] . " WHERE " . $config['id'] . "= '" . $select_value . "'  limit 1 ";
            //  echo $sql;
            $row = $this->db_resource->query($sql)->row();
            //  var_dump($row);exit();
            return @$row->dsc;
        }

        return $value;
    }

    public function gen_html($config, $select_value = "") { 
        // var_dump($this->db_resource);
        if ($this->db_resource == null) {
            $this->db_resource = $this->CI->db;
        }
        $multiple = @$config['multiple'];
        $multiple_html = '';
        if ($multiple == '1') {
            $multiple_html = '  multiple="multiple" ';
        }

        $readonly_html = '';

        if (!empty($select_value)) {
            $desc = $this->getValue($config, $select_value);
            //   var_dump($desc); exit();
            if (@$config['readonly'] == true) {
                $readonly_html = '  <input type="hidden" name="' . $config['name'] . '" value="' . $select_value . '" /> ';
            }
        }

        $required = 'required';
        if (isset($config['required'])) {
            if ($config['required'] == true) {
                $required = 'required="required"';
            } else if ($config['required'] == false) {
                $required = '';
            }
        }

        $html = $readonly_html . '<select class="form-control  select2  select2-allow-clear "  ' . $multiple_html . '  name="' . $config['name'] . '" id="' . $config['name'] . '"   ' . $required . '  > ';
        if ($select_value != "") {
            $html .= '<option value="' . $select_value . '" selected>' . $desc . '</option>';
        }
        $html .= '</select> ';



        return $html;
    }

    public function create_select2($config, $value_select = "") {
        $data = array();
        $config_ = $config;
        //     $config_ajax = $this->config($db, $config_);
        $gen_html_select2 = $this->CI->select2utils->gen_html($config_, $value_select);

        $data['html'] = $gen_html_select2;
        $data['config'] = $config_;
        // var_dump($data);
        //   exit();
        return $data;
    }

}

?>
