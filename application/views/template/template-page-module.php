
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view("template/include/header-lib"); ?> 
    </head>
    <body class="hold-transition login-page">
        <?php
        if (isset($page)) {
            $this->load->view("/modules/" . $page);
        }
        ?>

        <?php $this->load->view("template/include/footer-lib"); ?> 
    </body>
</html>
