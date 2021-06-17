<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$authen = $this->session->userdata(SESSION_AUTHEN);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view("template/include/css-lib"); ?> 
        <?php $this->load->view("template/include/js-lib"); ?> 
    </head>
    <body  class="main" >
        <?php
        if (isset($page)) {
            $this->load->view("/modules/" . $page);
        }
        ?>
       
        <script>
            createModalDiv();
        </script>
    </body>
</html>
