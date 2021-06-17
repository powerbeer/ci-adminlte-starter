<?php

defined('BASEPATH') OR exit('No direct script access allowed');

define("TBL_CUSTOMER_GROUP", "TBL_CUSTOMER_GROUP");
define("TBL_USER_GROUP", "TBL_USER_GROUP");

define('CUSTOMER_GROUP_CONFIG', json_encode(
                array(
                    "id" => "customer_group_id",
                    "name" => "customer_group_id",
                    "desc" => "customer_group_name",
                    "table" => TBL_CUSTOMER_GROUP,
                    "minimumInputLength" => 0,
                    "function_name" => "get/customer_group",
                    "url_main" => "lookup/Lookup"
                )
));


define('USER_GROUP_CONFIG', json_encode(
                array(
                    "id" => "user_group_id",
                    "name" => "user_group_id",
                    "desc" => "user_group_desc",
                    "table" => TBL_USER_GROUP,
                    "minimumInputLength" => 0,
                    "function_name" => "get/user_group",
                    "url_main" => "lookup/Lookup"
                )
));
?>