<?php

defined('BASEPATH') OR exit('No direct script access allowed');
 

 
define('MASSAGE_STATUS', 'message_status'); // success

define('STATUS_SUCCESS', 'success'); // success
define('STATUS_ERROR', 'error'); //   errors
//
//
//Log
define('LOG_WITH_SYSTEM', 1); //   errors
define('LOG_WITH_USER', 2); //   errors
//
 
//message
define('MESSAGE_CREATE_COMPLETE', 'บันทึกข้อมูลเรียบร้อย');
define('MESSAGE_UPDATE_COMPLETE', 'ปรับปรุงข้อมูลเรียบร้อย');
define('MESSAGE_REGISTER_ERROR', 'ไม่สามารถลงทะเบียนผู้ใช้งานใหม่ได้');
define('MESSAGE_UPDATE_ERROR', 'ไม่สามารถปรับปรุงข้อมูลได้');
define('MESSAGE_DELETE_COMPLETE', 'ลบข้อมูลเรียบร้อย');
define('MESSAGE_DELETE_ERROR', 'ไม่สามารถยกเลิกข้อมูลที่ท่านร้องขอได้');
define('MESSAGE_SEARCH_NOTFOUND', 'ไม้พบข้อมูลที่กำลังค้นหา');


//*command   */
define('CMD_CREATE', 'CREATE');
define('CMD_UPDATE', 'UPDATE');
define('CMD_DELETE', 'DELETE');

define("TABLE_LOG", "TBL_LOG");
define("PER_PAGE", 20);


define('L_USER_STATUS', json_encode(array("1"=>"ใช้งาน","2"=>"ถูกระงับชั่วคราว")));
 
?>