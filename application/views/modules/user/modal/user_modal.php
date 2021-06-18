<?php
$modal_id = create_form_id();
$form_id = create_form_id();  
?>
<div class="modal fade" id="<?php echo $modal_id; ?>"  data-backdrop="static">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <form  id="<?php echo $form_id; ?>" name="<?php echo $form_id; ?>" >
                <div class="modal-header">
                    <h4 class="modal-title">เพิ่มข้อมูลใหม่</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6" > 
                            <?php echo form_input("fullname", "fullname", "ชื่อ-นามสกุล", @$detail['fullname'], array('require' => true)); ?>

                            <?php echo form_input_html('user_group_id ', 'ประเภทผู้ใช้งาน', $select2_user_group['html']); ?>
                            <script>
                                 <?php generate_select2($select2_user_group['config']); ?>
                                </script>

                            <?php echo form_input("email", "email", "อีเมล์", @$detail['email'], array('require' => true)); ?>

                            <?php echo form_input("mobile_phone", "mobile_phone", "เบอร์โทรศัพท์มือถือ", @$detail['mobile_phone']); ?>

                        </div>
                        <div class="col-md-6" >

                            <?php echo form_input("username", "username", "Username", @$detail['username'], array('require' => true)); ?>

                            <?php echo form_input("password", "password", "Password", @$detail['password'], array('require' => true,"type"=>"password")); ?>
                        </div>
                    </div>
                </div> 
                <div class="modal-footer justify-content-between">
                     <input type="hidden" id="cmd_type" name="cmd_type" value="<?php echo $cmd_type; ?>" />
                    <button type="submit" id="btnSubmit" class="btn btn-primary">บันทึกข้อมูล</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button> 
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
<?php
$config = array('modal_id' => $modal_id);
generate_modal($config); 
generate_validate($form_id, 'btnSubmit', $url_post, $arr_validators_field);
?>
</script>