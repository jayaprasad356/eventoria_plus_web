<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

?>
<?php


if (isset($_POST['btnUpdate'])){
    $telegram = $db->escapeString($fn->xss_clean($_POST['telegram']));
    $instagram = $db->escapeString($fn->xss_clean($_POST['instagram']));
    $whatsapp = $db->escapeString($fn->xss_clean($_POST['whatsapp']));
    $paytm_payment_method = (isset($_POST['paytm_payment_method'])) ? $db->escapeString($fn->xss_clean($_POST['paytm_payment_method'])) : "";
    $paytm_merchant_id = (isset($_POST['paytm_merchant_id'])) ? $db->escapeString($fn->xss_clean($_POST['paytm_merchant_id'])) : "";
    $paytm_merchant_key = (isset($_POST['paytm_merchant_key'])) ? $db->escapeString($fn->xss_clean($_POST['paytm_merchant_key'])) : "";
    $paytm_mode = (isset($_POST['paytm_mode'])) ? $db->escapeString($fn->xss_clean($_POST['paytm_mode'])) : "";
  
    $error = array();

    $sql_query = "UPDATE settings SET whatsapp='$whatsapp',telegram='$telegram',instagram='$instagram',paytm_payment_method='$paytm_payment_method',paytm_merchant_id='$paytm_merchant_id',paytm_merchant_key='$paytm_merchant_key',paytm_mode='$paytm_mode' WHERE id='1'";
    $db->sql($sql_query);
    $result = $db->getResult();
    if (!empty($result)) {
        $result = 0;
    } else {
        $result = 1;
    }
    if ($result == 1) {
        $error['add_settings'] = " <section class='content-header'><span class='label label-success'>Settings Details Updated Successfully</span></section>";
    } else {
        $error['add_settings'] = " <span class='label label-danger'>Failed to update</span>";
    }

}
?>
<section class="content-header">
    <h1>Settings<small><a href='home.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Home</a></small></h1>

    <?php echo isset($error['add_settings']) ? $error['add_settings'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
           
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Settings</h3>

                </div><!-- /.box-header -->
                <!-- form start -->
                <form name="add_settings" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <?php
                        $sql = "SELECT * FROM settings WHERE id = '1'";
                        $db->sql($sql);
                        $res = $db->getResult();
                        $num = $db->numRows();
                        if($num >= 1){
                            ?>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Whatsapp</label>
                                <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="<?php echo $res[0]['whatsapp'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Telegram</label>
                                <input type="text" class="form-control" id="telegram" name="telegram" value="<?php echo $res[0]['telegram'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Instagram</label>
                                <input type="text" class="form-control" id="instagram" name="instagram" value="<?php echo $res[0]['instagram'] ?>">
                            </div>
                            <h5>Paytm Payments </h5>
                        <hr>
                        <div class="form-group">
                            <label for="paytm_payment_method">Paytm Payments <small>[ Enable / Disable ] </small></label><br>
                            <input type="checkbox" id="paytm_payment_method_btn" class="js-switch" <?= (isset($res[0]['paytm_payment_method']) && !empty($res[0]['paytm_payment_method']) && $res[0]['paytm_payment_method'] == '1') ? 'checked' : ""; ?>>
                            <input type="hidden" id="paytm_payment_method" name="paytm_payment_method" value="<?= (isset($res[0]['paytm_payment_method']) && !empty($res[0]['paytm_payment_method'])) ? $res[0]['paytm_payment_method'] : 0; ?>">
                        </div>
                        <div class="form-group">
                            <label for="paytm_merchant_id">Merchant ID</label>
                            <input type="text" class="form-control" name="paytm_merchant_id" value="<?= (isset($res[0]['paytm_merchant_id'])) ? $res[0]['paytm_merchant_id'] : '' ?>" placeholder="Paytm Merchant ID" />
                        </div>
                        <div class="form-group">
                            <label for="paytm_merchant_key">Merchant Key</label>
                            <input type="text" class="form-control" name="paytm_merchant_key" value="<?= (isset($res[0]['paytm_merchant_key'])) ? $res[0]['paytm_merchant_key'] : '' ?>" placeholder="Paytm Merchant Key " />
                        </div>

                        <div class="form-group">
                                        <label for="">Paytm Payment Mode <small>[ sandbox / live ]</small></label>
                                        <select name="paytm_mode" class="form-control">
                                            <option value="sandbox" <?= (isset($res[0]['paytm_mode']) && $res[0]['paytm_mode'] == 'sandbox') ? "selected" : "" ?>>Sandbox ( Testing )</option>
                                            <option value="production" <?= (isset($res[0]['paytm_mode']) && $res[0]['paytm_mode'] == 'production') ? "selected" : "" ?>>Production ( Live )</option>
                                        </select>
                                    </div>
                            <?php
                        }
                        ?>
                    </div>
                  
                    <!-- /.box-body -->

                    <div class="box-footer">
                         <button type="submit" class="btn btn-success" name="btnUpdate">Update</button>
                        
                    </div>

                </form>

            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>
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