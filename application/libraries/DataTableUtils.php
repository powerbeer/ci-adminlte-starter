<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DataTableUtils {

    protected $CI;
    protected $folder_resource = "";
    protected $root_path = "";

    function __construct() {
        $this->CI = & get_instance();
        // $this->root_path=FCPATH;
    }

    public function createNavPage($page_url, $datatable, $orderby = "1", $order_type = "asc") {

        $total = $datatable['total_rows'];
        $perpage = $datatable['no_of_records_per_page'];
        $page = $datatable['total_pages'];
        if ($total > 0) {
            if ($page <= 0) {
                $page = 1;
            }
            $pre_page = $page - 1;
            $page_next = $page + 1;
            $pre_page_disable = "";
            $page_next_disable = "";
            //echo 'pre_page='.$pre_page;
            if ($pre_page <= 0) {
                $pre_page = 1;
                $pre_page_disable = "disabled";
            }

            // $perpage = 20;
            $nav_total = $total / $perpage;
            $nav_total++;
            $current_i = 0;

            if ($page_next >= $nav_total) {
                $page_next_disable = "disabled";
            }

            $html = '
        <div class="card-footer"> 
                    <label   >ข้อมูลทั้งหมด ' . number_format((int) $total) . ' รายการ</label>

                
                       <select id="select1" name="select1" class=" form-control-sm  float-right"    onchange="gotoURLPage(this.value);">';

            for ($i = 1; $i < $nav_total; $i++) {
                $select_ = '';
                //echo 'page =='.$page .' i=='.$i;
                if ($page == $i) {
                    $select_ = ' selected';
                }
                $html .= '  <option value="' . $page_url . "/" . $i . "/" . $orderby . '/' . $order_type . '"  ' . $select_ . '>หน้า ' . $i . '</option>';
            }
            $html .= '</select>  
                </div>';

            return $html;
        } else {

            return '';
        }
    }

}
