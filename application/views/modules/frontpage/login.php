<?php
$form_id = create_form_id();
?>
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a  class="h5"><?php echo APP_TITLE; ?></a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">กรุณาเข้าระบบ</p>

            <form  id="<?php echo $form_id; ?>" name="<?php echo $form_id; ?>" >
                <div class="input-group mb-3 form-group">
                    <input type="text" class="form-control" placeholder="username" id="username" name="username">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group form-group  mb-3">
                    <input type="password" class="form-control" placeholder="กรอกรหัสผ่าน" id="password" name="password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" id="btnSubmit" class="btn btn-primary btn-block">เข้าระบบ</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <!-- /.social-auth-links -->

            <p class="mb-1">
                <a href="forgot-password.html">ลืมรหัสผ่าน</a>
            </p> 
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->

<script>
<?php
generate_validate($form_id, 'btnSubmit', $url_post, $arr_validators_field);
?>
</script>