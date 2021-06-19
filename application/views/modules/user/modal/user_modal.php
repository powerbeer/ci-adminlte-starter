<?php
$title_form = json_decode(TITLE_FORM, true);

$modal_id = create_form_id();
$form_id = create_form_id();
?>
<div class="modal fade" id="<?php echo $modal_id; ?>"  data-backdrop="static">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <form  id="<?php echo $form_id; ?>" name="<?php echo $form_id; ?>" >
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo $title_form[$cmd_type]; ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5" > 
                            <?php echo form_input("fullname", "fullname", "ชื่อ-นามสกุล", @$detail['fullname'], array('require' => true)); ?>

                            <?php echo form_input_html('user_group_id ', 'ประเภทผู้ใช้งาน', $select2_user_group['html']); ?>
                            <script>
<?php generate_select2($select2_user_group['config']); ?>
                            </script>

                            <?php echo form_input("email", "email", "อีเมล์", @$detail['email'], array('require' => true)); ?>

                            <?php echo form_input("mobile_phone", "mobile_phone", "เบอร์โทรศัพท์มือถือ", @$detail['mobile_phone']); ?>

                        </div>
                        <div class="col-md-5" >

                            <?php
                            $readonly = false;
                            if ($cmd_type == CMD_UPDATE) {
                                $readonly = true;
                            }
                            echo form_input("username", "username", "Username", @$detail['username'], array('require' => true, 'readonly' => $readonly));
                            ?>

                            <?php
                            if ($cmd_type != CMD_UPDATE) {
                                echo form_input("password", "password", "Password", @$detail['password'], array('require' => true, "type" => "password"));
                            }
                            ?>

                            <h5 class="p-0 m-0">ไฟล์เอกสาร</h5>
                            <div class="row">  
                                <div class="col-md-12">
                                    <div class="form-group"> 
                                        <label class="form-control-label" for="resource_code">แนบไฟล์เอกสารที่เกี่ยวข้อง</label>
                                        <?php
                                        echo $upload_file_div;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="col-md-2" >
                             <label class="form-control-label" >รูปโปรไฟล์</label>
                              <input type="file" name="file_upload" id="file_upload" accesskey="file_upload" accept="image/*" class="dropify" data-max-file-size="1M"  data-default-file="<?php echo ''; ?>"  >
                         </div>
                    </div> 
                    <?php ui_modal_form_button_save(); ?>
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
generate_upload($config_upload);
generate_validate($form_id, 'btnSubmit', $url_post, $arr_validators_field, POST_MULTIPLE);
generate_dropify($config);
?>
</script>