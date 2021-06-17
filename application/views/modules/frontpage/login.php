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
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password">
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
            generate_validate($form_id, 'btnSubmit', 'ccc', $arr_validators_field);
        
        ?>
</script>