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
    <body class="hold-transition sidebar-mini layout-fixed main" data-panel-auto-height-mode="height">
        <div class="wrapper">

            <?php $this->load->view("template/include/navbar"); ?> 

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="index3.html" class="brand-link text-sm">
                    <img src="assets/dist/img/AdminLTELogo.png" alt="<?php echo APP_TITLE; ?>" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light "><?php echo APP_NAME; ?></span>
                </a>


                <?php $this->load->view("template/include/sitebar"); ?> 
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <?php
                if (isset($page)) {
                    $this->load->view("/modules/" . $page);
                }
                ?>
            </div>
            <!-- /.content-wrapper -->


            <!-- /.content-wrapper -->
            <?php // $this->load->view("template/include/paging-footer"); ?> 
            
        </div>
        <!-- ./wrapper -->
        <script>
            createModalDiv();
        </script>
    </body>
</html>
