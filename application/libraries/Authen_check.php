<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authen_check {

    protected $CI;

    public function __construct() {
        $this->CI = & get_instance();
        //var_dump($_SESSION);
        //echo 'hook!!!!!!!1';
        $this->check_session();
    }

    public function check_session() {

        // var_dump($_SESSION);

        $class_ = strtolower($this->CI->router->class);
       $method_ = $this->CI->router->method;
      
        $dir_ = $this->CI->router->directory;
        $auth_class_public = AUTH_CLASS_PUBLIC;
         $url=$dir_.$method_;

        $authen = $this->CI->session->userdata(SESSION_AUTHEN);

        $is_authen = true;

       
        if (!in_array($class_, json_decode($auth_class_public, true)) && empty($authen)  && empty($dir_)) {
            // echo 'user_id='.$user_id;
            $is_authen = false;
        } else if (!empty($dir_)  &&  empty($authen) ) {
           
            if (in_array($dir_, json_decode($auth_class_public, true))) {
                $is_authen = true;
            }
            if (in_array($url, json_decode($auth_class_public, true))) {
                  $is_authen = true;
                 //  var_dump($url  . '|'.$dir_  );
              //  exit();
            }else{
                $is_authen=false;
            }
          //  echo 'aaaaaaaaaa';
        }else{
      //      echo 'ccccccccccc';
        }

   //    echo 'is_authen=='.$is_authen;
        if ($is_authen == false) {
            redirect("Login");
        }
    }

}

?>