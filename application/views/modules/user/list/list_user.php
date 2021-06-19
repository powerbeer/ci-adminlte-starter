<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo $title; ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">

                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                          <?php echo  form_search(base_url(uri_string()),$search_text); ?>
                        
                    </h3>

                    <div class="card-tools">
                        <div class="btn-group">
                            <button type="button" class="btn btn-info" onclick="openURLModal('<?php echo site_url($url_main . '/form_modal/' . CMD_CREATE) ?>')">สร้างใหม่</button>
                            <button type="button" class="btn btn-info dropdown-toggle  dropdown-icon" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Separated link</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-striped  ">
                        <thead>
                            <tr>
                                <th class="w-20">#</th>
                                <th>ชื่อ-นามสกุล</th>
                                <th>สิทธิ</th>
                                <th>Account</th>
                                <th>สถานะผู้ใช้</th>
                                <th class="w-100">คำสั่ง</th>
                            </tr>
                        </thead>
                        <?php
                        if (isset($datatable) && @(int) $datatable['total_rows'] > 0) {

                            $offset = $datatable['offset'];
                            $result = $datatable['result'];
                          //  var_dump($result);
                            
                            for ($i = 0; $i < count($result); $i++) {
                                $row=$result[$i];
                                $id=$row->user_id;
                                ?>
                                <tbody>
                                    <tr>
                                        <td><?php echo ++$offset; ?></td>
                                        <td><?php echo $row->fullname;  ?></td>
                                        <td><?php echo $row->user_group_id;  ?></td>
                                        <td><?php echo $row->username;  ?></td>
                                        <th><?php echo $row->mobile_phone;  ?></th>
                                        <td>
                                            <div class="btn-group ">
                                                <button type="button" class="btn btn-info" onclick="openURLModal('<?php echo site_url($url_main . '/form_modal/' . CMD_UPDATE.'/'.$id) ?>')" >แก้ไข</button>
                                                <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#">ลบข้อมูลนี้</a>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
        <?php
    }
} else {
    echo datatable_nodata('ไม่พบข้อมูล', '8');
}
?>
                        </tbody>

                    </table>
                </div>

<?php
if (isset($datatable) && @(int) $datatable['total_rows'] > 0) {
    echo $page_nav_view;
}
?>

                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

</section>
<!-- /.content -->