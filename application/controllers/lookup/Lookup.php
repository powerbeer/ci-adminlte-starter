<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lookup extends CI_Controller {

    // private $district_name_ar;
    private $staffid;
    private $password;

    function __construct() {
        parent::__construct();

        $this->load->library('Select2Utils', '', 'select2utils');
        $this->db->cache_off();
    }

    public function get($table, $pk, $desc) {
        $config = array(
            "id" => $pk,
            "name" => $pk,
            "desc" => $desc,
            "table" => $table,
            "minimumInputLength" => 0,
            "function_name" => "get/" . $table,
            "url_main" => "lookup/Lookup"
        );

        $txtsearch = $this->input->get('txtsearch');
        if ($txtsearch != '') {
            $config['text_search'] = $txtsearch;
        }
        $this->select2utils->show_json($config);
    }

}
