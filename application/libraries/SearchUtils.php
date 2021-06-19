<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class SearchUtils {

    protected $CI;
    private $class_name;
    private $session_search_obj;
    private $param_search;
    private $sql_app;
    private $sql_app_ar;
    private $search_text = array();
    private $url_reset;
    private $post;
    private $session_key = '';

    function __construct() {
        $this->CI = & get_instance();
        $this->class_name = $this->CI->router->class;
        $this->session_key = $this->class_name . '_config';
    }

    public function config($config = array()) {

        $this->url_reset = $config['url_reset'];
        $this->param_search = $config['ar_param_search'];
        $this->sql_app_ar = @$config['sql_app_ar'];

        //     var_dump($this->param_search);exit();
        $session_config = $this->CI->session->userdata($this->session_key);
        //var_dump($session_config);
        $user_data = array();
        if (isset($config)) {
            $sql_app = "";
            if (is_array($this->sql_app_ar)) {
                //    var_dump($this->sql_app_ar);exit();
                for ($i = 0; $i < count($this->sql_app_ar); $i++) {
                    if ($i == 0) {
                        $sql_app = " " . $this->sql_app_ar[$i];
                    } else {
                        $sql_app .= " AND " . $this->sql_app_ar[$i];
                    }
                }

                if (trim($sql_app) != '') {
                    $this->sql_app = $sql_app;
                }
            }
            //   echo 'ccc' .$this->sql_app;
            $config['search_text'] = $this->getSearchText();
            $config['ar_param_search'] = $this->param_search;
            $config['sql_app'] = $this->sql_app;
        } else {
            $config['ar_param_search'] = $session_config['param_search'];
            $config['search_text'] = $session_config['search_text'];
            $this->sql_app = $session_config['sql_app'];
            $config['sql_app'] = $this->sql_app;
        }
        //  echo 'xxx';
        // exit();

        if (isset($config['sql_app']) != null) {
            //$this->sql_app = $config['sql_app'];
            $user_data[$this->session_key] = $config;
            $this->CI->session->set_userdata($user_data);
        } else {
            $config['sql_app'] = null;
            $user_data[$this->session_key] = $config;
            $this->CI->session->set_userdata($user_data);
            //  $this->sql_app = $session_config['sql_app'];
        }
    }

    public function get_sqlString() {
        $session_config = $this->CI->session->userdata($this->session_key);
        $sql_app = @$session_config['sql_app'];
        //    var_dump($session_config);
        //  exit();
        return $sql_app;
    }

    public function set_search_text($search_text) {
   
        $this->CI->session->set_userdata(array($this->class_name . '_search_text'=>$search_text));
    }

    public function getSearchText() {
        $val = $this->CI->session->userdata($this->class_name . '_search_text');
        //var_dump($val);
        return $val;
    }
    
      public function clearSearchText() {
      $this->CI->session->unset_userdata($this->class_name . '_search_text'); 
    }

    public function MakeSQLSearch($list_column_search) {
        $sql_app = '';
        $sql_app_ret = "";
       $search_text = $this->CI->session->userdata($this->class_name . '_search_text');
        if (!empty($search_text)) {
            for ($i = 0; $i < count($list_column_search); $i++) {
                if ($i == 0) {
                    $sql_app = " " . $list_column_search[$i] . " like '%$search_text%'";
                } else {
                    $sql_app .= " OR " . $list_column_search[$i] . " like '%$search_text%'";
                }
            }

            if (strlen($sql_app) > 0) {
                $sql_app_ret = "   ($sql_app) ";
            }
        }
       // var_dump($sql_app_ret);

        return $sql_app_ret;
    }

    public function MakeSQLAPP_ARRAY($config) {

        $key_check = "";
        $list_param = array();
        $list_return = array();
        $sql_app_ar = array();
        for ($i = 0; $i < count($config); $i++) {
            $ar_data = $config[$i];
            $name = $ar_data['name'];
            $isbase64 = $ar_data['isbase64'];
            $field = $ar_data['field'];
            $type = $ar_data['type'];
            $eq_type = @$ar_data['eq_type'];
            if (empty($eq_type)) {
                $eq_type = '=';
            } else if ($eq_type == 'like') {
                $eq_type = ' like ';
            }
            if ($ar_data['param_type'] == 'get') {
                $param = $this->CI->input->get($name);
            } else if ($ar_data['param_type'] == 'post') {
                $param = $this->CI->input->post($name);
            } else if ($ar_data['param_type'] == 'session') {
                $param = $this->CI->input->userdata($name);
            } else if ($ar_data['param_type'] == 'manual') {
                $value_ = $ar_data['value'];
                $param = $value_;
            }
            if (!empty($param)) {
                $key_check = "in_1";
                $param_decode = $param;
                if ($isbase64 == true) {
                    $param_decode = base64_decode($param);
                }
                //   var_dump($param_decode);
                if (strtoupper($param_decode) != 'ALL') {
                    if (trim($param_decode) != '') {
                        if ($type == 'text') {
                            if ($eq_type == 'like') {
                                $param_decode = "  $field  $eq_type    '%$param_decode%' ";
                            } else {
                                $param_decode = "  $field  = '$param_decode' ";
                            }
                        } else if ($type == 'number') {
                            $param_decode = "  $field  = $param_decode ";
                        } else {
                            $param_decode = "  $field  = '$param_decode' ";
                        }
                        $list_param[$field] = $param;
                        $sql_app_ar[] = $param_decode;
                    }

                    $session_data = array($name => $param_decode);
                    $this->CI->session->set_userdata($session_data);
                } else if (strtoupper($param_decode) == 'ALL' && !empty($param_decode)) {
                    $session_data = array($name => $param_decode);
                    $this->CI->session->unset_userdata($name);
                    // var_dump($session_data);
                } else {
                    // echo 'ccaaaaaaaaacc';
                }
            } else {
                $key_check = "in_2";
                ///  echo 'xxxxxxxxx';
                //     var_dump($this->session_key);exit();
                $s = $this->CI->session->userdata($this->session_key);
                $list_param = $s['ar_param_search'];
                // var_dump($s);
                //  echo '1';
                //exit();
                $this->CI->session->set_userdata($s);
                $param_decode = trim($this->CI->session->userdata($name));
                //var_dump($param_decode);
                if (!empty($param_decode)) {
                    if (strtoupper($param_decode) != 'ALL') {
                        //   if (trim($param_decode) != '') {
                        if ($type == 'text') {
                            //  $param_decode = "  $field  = '$param_decode' ";
                        } else if ($type == 'number') {
                            // $param_decode = "  $field  = $param_decode ";
                        }
                        $sql_app_ar[] = $param_decode;
                        //  $list_param[$field] = $param;
                    }
                }
            }
        }

        //var_dump($list_param);
        //   exit();
        //    var_dump($list_param);exit();
        $list_return['ar_param_search'] = $list_param;
        $list_return['key_check'] = $key_check;

        $list_return['sql_app_ar'] = $sql_app_ar;
        return $list_return;
    }

    public function setSearchParam() {
        // $this->input->post
        //   echo 'cc=='. count($this->param_search);
        //$user_data=array();
        if ($this->CI->input->post()) {
            $user_data = array();
            $param = $this->CI->input->post();
            // var_dump($param);
            //exit();

            foreach ($param as $param_name => $param_val) {
                $user_data[$this->session_key][$param_name] = trim($param_val);
            }

            $this->CI->session->set_userdata($user_data);
        }
    }

    public function resetSearchParam() {
        // $user_data[$this->class_name] = null;
        //  @$this->CI->session->unset_userdata("startdate");
        $list_remove = array("startdate", "todate");
        @$this->CI->session->unset_userdata($list_remove);
        $this->CI->session->unset_userdata($this->session_key);
        $this->session_search_obj = null;
    }

    public function getSessionSearch() {
        //  var_dump($this->session_search_obj);
        $this->session_search_obj = @$this->CI->session->userdata($this->session_key);

        return $this->session_search_obj;
    }

    public function init() {
        $reset = $this->CI->input->get("reset");

        if ($this->CI->input->post()) {
            $this->setSearchParam();
        } else if ($reset == '1') {
            $this->resetSearchParam();
        } else {
            
        }
    }

    public function getLabelSearch() {
        $html = '';
        for ($i = 0; $i < count($this->search_text); $i++) {
            $html .= ' ' . $this->search_text[$i];
        }
        $html_ret = '';
        if ($html != '') {
            $html_ret = ' <li class="fa fa-filter"></li> ' . $html . '<a  href="' . $this->url_reset . '?reset=1"  data-toggle="tooltip" data-original-title="เคลียร์คำค้น"  class="btn  btn-sm btn-icon   btn-round waves-effect waves-classic"     >
                    <li class="fa fa-remove"></li>
                </a>';
        }

        return $html_ret;
    }

    public function showButtonSearch($show_type = "top") {

        if ($show_type == 'top') {
            $html = $this->getLabelSearch() . ' 
                <a class="btn btn-sm btn-icon   btn-outline btn-defalte  btn-round waves-effect waves-classic"  
                id="menuOption" data-toggle="collapse" href="#CollapseDefaultOne"   data-toggle="tooltip" data-original-title="ค้นหาข้อมูล"  
                data-parent="#AccordionDefault" aria-expanded="false" aria-controls="CollapseDefaultOne">
                    <i class="fa fa-search"></i> ค้นหาแบบละเอียด</a> ';
        } else if ($show_type == 'buttom_float') {
            $html = '<!-- Site Action -->
                <button class=" btn btn-floating btn-success"   type="button">
                  <i class="icon wb-plus" aria-hidden="true"></i> 
                </button>
                <!-- End Site Action --> ';
        }
        return $html;
    }

    public function showButtonExportExcel($url) {

        $html = '<a class="btn btn-sm btn-icon btn-primary   btn-round "   data-toggle="tooltip" data-original-title="ส่งออกเป็นไฟล์ Excel "  
                 href="' . $url . '" >  <i class="fa fa-file-excel-o"></i> ส่งออก Excel</a> ';
        return $html;
    }

    public function getParam($key) {
        $val = "";
        $v = $this->CI->input->post($key);

        if (isset($v)) {
            $val = @$this->CI->input->post($key);
        } else {
            // var_dump($_SESSION);
            $s = $this->CI->session->userdata($this->session_key);
            //var_dump($s);
            // exit();
            $param = @json_decode(json_encode($s), true);
            //  var_dump($param['ar_param_search']);exit();
            $val = @$param['ar_param_search'][$key];
            //   echo 'xx=' . $val;
            //     exit();
            //  var_dump($param);
            //exit();
        }


        return $val;
    }

    public function getSearchParam($sql_addon_str = "") {

        $str_sql = '';
        $sql_addon = array();
        $this->search_text = array();

        $sql_addon_str .= trim($this->sql_app);

        $_param_all = @$this->session_search_obj;


        for ($i = 0; $i < count($this->param_search); $i++) {
            $ar = $this->param_search[$i];
            //var_dump($ar);
            //exit();
            //var_dump($_SESSION);
            //exit();
            // echo 'fffffffffffff='.$ar[0];
            // $this->session_search_obj = @$this->CI->session->userdata($this->class_name);
            //var_dump($session_search_obj);
            // exit();

            $check_ar = $ar['name'];
            $type = $ar['type'];
            $condition_ = @$ar['condition'];

            if (is_array($check_ar)) {
                $list = $ar['name'];
                $field = $ar['field'];
                //var_dump($list);
                $sql_aa = ' (TRUNC(' . $field . ') BETWEEN ';
                for ($a = 0; $a < count($list); $a++) {
                    $ar_ = $list[$a];
                    $_param = @$this->session_search_obj[$ar_['name']];
                    // var_dump($ar_);
                    //exit();
                    if ($a == 1) {
                        $sql_aa .= " AND ";
                    }
                    $sql_aa .= " TO_DATE('" . $this->CI->func_custom->toEngDate($_param) . "','DD/MM/YYYY') ";
                }

                $sql_aa .= ')';

                $sql_addon[] = $sql_aa;
            } else if (isset($ar['field'])) {
                $_param = @$this->session_search_obj[$ar['name']];

                //  var_dump($type);
                if ($_param != '') {
                    if ($type == 'date') {
                        $sql_addon[] .= "   to_char(" . $ar['field'] . ",'dd/mm/yyyy')  =  '" . $this->CI->func_custom->toEngDate($_param) . "'";
                    } else if ($type == "date_between") {
                        $_param_ = explode("-", $_param);
                        $date_start = trim($_param_[0]);
                        $to_date = trim($_param_[1]);
                        $sql_addon[] .= "  trunc(" . $ar['field'] . ") between to_date('" . $date_start . "','dd/mm/yyyy') and to_date('" . $to_date . "','dd/mm/yyyy') ";
                    } else {
                        if (@$condition_ == 'eq') {
                            $sql_addon[] .= "   " . $ar['field'] . "  =  '" . trim($_param) . "'";
                        } else {
                            $sql_addon[] .= "   " . $ar['field'] . "  LIKE  '%" . trim($_param) . "%'";
                        }
                    }

                    $this->search_text[] = '<span class="badge badge-round badge-primary">' . $ar['label'] . ':' . $_param . '</span>';
                }
            }
        }

        //var_dump($sql_addon);
        if (count($sql_addon) > 0) {
            $str_sql = '(';
            for ($i = 0; $i < count($sql_addon); $i++) {
                if ($i > 0) {
                    $str_sql .= " AND ";
                } else {
                    $str_sql .= "   ";
                }
                $str_sql .= $sql_addon[$i];
            }
            $str_sql .= ')';

            if (trim($sql_addon_str) != "") {
                $str_sql .= " AND ";
            }
        }

        if (trim($sql_addon_str) != "") {
            $str_sql .= "  " . $sql_addon_str;
        }
        //  echo $str_sql;
        //  exit();



        return $str_sql;
    }

}

?>
