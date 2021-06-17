<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">Alexander Pierce</a>
        </div>
    </div>


    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="pages/widgets.html" class="nav-link">
                    <i class="nav-icon fa fa-dashboard"></i>
                    <p>
                        แดชบอร์ด
                        <span class="right badge badge-danger">New</span>
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="pages/widgets.html" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        ขายหน้าร้าน
                        <span class="right badge badge-danger">New</span>
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-chart-pie"></i>
                    <p>
                        ประจำวัน
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./index2.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>รายการค้างจ่าย</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./index3.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>ตั้งค่า</p>
                        </a>
                    </li>
                </ul>
            </li>  
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-table"></i>
                    <p>
                        สินค้าและบริการ
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="pages/tables/simple.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>ข้อมูลสินค้า/บริการ</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/tables/data.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>นำเข้า(PO)</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/tables/jsgrid.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>โอนสินค้า</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-header">ตั้งค่าระบบ</li>
            <li class="nav-item">
                <a href="pages/calendar.html" class="nav-link">
                    <i class="nav-icon far fa-users"></i>
                    <p>
                        ข้อมูลผู้ใช้งาน
                        <span class="badge badge-info right">2</span>
                    </p>
                </a>
            </li> 
            <li class="nav-item">
                <a href="pages/calendar.html" class="nav-link">
                    <i class="nav-icon far fa-users"></i>
                    <p>
                        ร้านค้า
                        <span class="badge badge-info right">2</span>
                    </p>
                </a>
            </li> 
            <li class="nav-item">
                <a href="pages/calendar.html" class="nav-link">
                    <i class="nav-icon far fa-users"></i>
                    <p>
                        สาขา
                        <span class="badge badge-info right">2</span>
                    </p>
                </a>
            </li> 
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->