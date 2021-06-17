
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view("template/include/css-lib"); ?> 
          <?php $this->load->view("template/include/js-lib"); ?> 
    </head>
    <body class="hold-transition login-page">
        <?php
        if (isset($page)) {
            $this->load->view("/modules/" . $page);
        }
        ?>

      
    </body>
</html>
