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
    $error = array();

    $sql_query = "UPDATE settings SET whatsapp='$whatsapp',telegram='$telegram',instagram='$instagram'WHERE id='1'";
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
        $error['add_settings'] = " <span class='label label-danger'>Failed add slide</span>";
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
<?php $db->disconnect(); ?>