<?php

    // หน้าที่ไม่มีทำการ login
    define('AUTH_CLASS_PUBLIC', json_encode(array("login", "logout", "register", "forgotpassword")));
    
?>