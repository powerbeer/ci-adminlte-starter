<!DOCTYPE html>
<html lang="en">
    <head>
       <?php $this->load->view("template/include/header-lib"); ?> 
          <?php $this->load->view("template/include/js-lib"); ?> 
    </head>
    <body class="hold-transition sidebar-mini layout-fixed" data-panel-auto-height-mode="height">
        <div class="wrapper">

            <?php $this->load->view("template/include/navbar"); ?> 

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="index3.html" class="brand-link text-sm">
                    <img src="assets/dist/img/AdminLTELogo.png" alt="<?php echo APP_TITLE;  ?>" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light ">AdminLTE 3</span>
                </a>

                 <?php $this->load->view("template/include/sitebar"); ?> 
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
                <div class="nav navbar navbar-expand navbar-white navbar-light border-bottom p-0">

                    <a class="nav-link bg-light"  href="javascript:void(0)" data-widget="iframe-scrollleft"><i class="fas fa-angle-double-left"></i></a>
                    <ul class="navbar-nav overflow-hidden" role="tablist"></ul>
                    <a class="nav-link bg-light"  href="javascript:void(0)" data-widget="iframe-scrollright"><i class="fas fa-angle-double-right"></i></a>
                    <a class="nav-link bg-light" href="javascript:void(0)"  data-widget="iframe-fullscreen"><i class="fas fa-expand"></i></a>
                    <div class="nav-item dropdown">
                        <a class="nav-link bg-danger dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-close"></i></a>
                        <div class="dropdown-menu mt-0">
                            <a class="dropdown-item" href="javascript:void(0)" data-widget="iframe-close" data-type="all">ปิด Tab ทั้งหมด</a>
                            <a class="dropdown-item"  href="javascript:void(0)" data-widget="iframe-close" data-type="all-other">ปิด Tab อันอื่น</a>
                        </div>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-empty">
                        <h2 class="display-4">No tab selected!</h2>
                    </div>
                    <div class="tab-loading">
                        <div>
                            <h2 class="display-4">Tab is loading <i class="fa fa-sync fa-spin"></i></h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-wrapper -->
             <?php $this->load->view("template/include/footer"); ?> 
           
        </div>
        <!-- ./wrapper -->
 
    </body>
</html>
