<?php
include_once('../includes/functions.php');
$function = new functions;
include_once('../includes/custom-functions.php');
$fn = new custom_functions;

?>
<?php
   $sql = "SELECT * FROM settings WHERE id = '1'";
   $db->sql($sql);
   $res = $db->getResult();

?>
<section class="content-header">
    <h1>Terms & Conditions<small><a href='home.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Home</a></small></h1>

    <?php echo isset($error['add_settings']) ? $error['add_settings'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
           
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">

                </div><!-- /.box-header -->
                <!-- form start -->
                <form name="add_settings" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                        <label for="exampleInputEmail1">Whatsapp</label>
                                        <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="<?php echo $res[0]['whatsapp'] ?>" readonly>
                                </div>
                                <div class="col-md-4">
                                        <label for="exampleInputEmail1">Telegram</label>
                                        <input type="text" class="form-control" id="telegram" name="telegram" value="<?php echo $res[0]['telegram'] ?>" readonly>
                                </div>
                                <div class="col-md-4">
                                        <label for="exampleInputEmail1">Instagram</label>
                                        <input type="text" class="form-control" id="instagram" name="instagram" value="<?php echo $res[0]['instagram'] ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="terms_conditions">Terms & Conditions :</label> <i class="text-danger asterik">*</i><?php echo isset($error['terms_conditions']) ? $error['terms_conditions'] : ''; ?>
                            <textarea name="terms_conditions" id="terms_conditions" class="form-control" rows="10"><?php echo $res[0]['terms_conditions']; ?></textarea>
                            <script type="text/javascript" src="../css/js/ckeditor/ckeditor.js"></script>
                            <script type="text/javascript">
                                CKEDITOR.replace('terms_conditions');
                            </script>
                        </div>              
                    
                    </div>
                  
                    <!-- /.box-body -->

                </form>

            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>
<?php $db->disconnect(); ?>
<script>
    $('#add_settings').validate({
        rules: {
            terms_conditions: {
                required: function(textarea) {
                    CKEDITOR.instances[textarea.id].updateElement();
                    var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                    return editorcontent.length === 0;
                }
            }
        }
    });
</script>

<script>
        var changeCheckbox = document.querySelector('#paytm_payment_method_btn');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        if ($(this).is(':checked')) {
            $('#paytm_payment_method').val(1);
        } else {
            $('#paytm_payment_method').val(0);
        }
    };

</script>

<?php $db->disconnect(); ?>