<?php session_start();
ob_start();
include_once('../includes/crud.php');
$db = new Database;
include_once('../includes/custom-functions.php');
$fn = new custom_functions();
$db->connect();
date_default_timezone_set('Asia/Kolkata');
$sql = "SELECT * FROM settings";
$db->sql($sql);
$res = $db->getResult();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/ico" href="../images/logo.png">
    <title>Shop Registration - Eventoria Plus</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
            folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="../plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
</head>

<body>
    <!-- Content Wrapper. Contains page content -->
    <div class="col-md-4 col-md-offset-4 " style="margin-top:5px;">
        <!-- general form elements -->
        <div class='row'>
            <div class="col-md-12 text-center">
                <img src="../images/logo.png" height="100">
                <h3>Shop Registration form</h3>
            </div>
            <div class="box box-primary col-md-12">
                <!-- form start -->
                <form method="post" action="public/db-operation.php" id="add_shop_form" enctype="multipart/form-data">
                    <input type="hidden" id="add_shop" name="add_shop" required="" value="1" aria-required="true">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="">Name</label><i class="text-danger asterik">*</i>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="">Shop Name</label><i class="text-danger asterik">*</i>
                            <input type="text" class="form-control" name="shop_name" required>
                        </div>
                        <div class="form-group">
                            <label for="">Email</label><i class="text-danger asterik">*</i>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="">Mobile</label><i class="text-danger asterik">*</i>
                            <input type="number" class="form-control" name="mobile" required>
                        </div>
                        <div class="form-group">
                            <label for="">Password</label><i class="text-danger asterik">*</i>
                            <input type="text" class="form-control" name="password" id="password" required>
                        </div>
                        <div class="form-group">
                            <label for="">Confirm Password</label><i class="text-danger asterik">*</i>
                            <input type="text" class="form-control" name="confirm_password" required>
                        </div>
                        <div class="form-group">
                            <label for="">Pincode</label><i class="text-danger asterik">*</i>
                            <input type="number" class="form-control" name="pincode" required>
                        </div>
                        <div class="form-group">
                            <label for="">Street</label><i class="text-danger asterik">*</i>
                            <input type="text" class="form-control" name="street" required>
                        </div>
                        <div class="form-group">
                            <label for="">State</label><i class="text-danger asterik">*</i>
                            <input type="text" class="form-control" name="state" required>
                        </div>
                        <div class="form-group">
                            <label for="">Latitude</label><i class="text-danger asterik">*</i>
                            <input type="text" class="form-control" name="latitude" required>
                        </div>
                        <div class="form-group">
                            <label for="">Longitude</label><i class="text-danger asterik">*</i>
                            <input type="text" class="form-control" name="longitude" required>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-10">
                                <div class="form-group">
                                    <label for="logo">Logo</label><i class="text-danger asterik">*</i>
                                    <input type="file" class="form-control" name="logo" id="logo" required /><br>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <input type="checkbox" id="agreed" name="agreed" value="1" required> By clicking Sign Up, you agree to our <a href='../seller-play-store-terms-conditions.php' target='_blank' >Terms & Conditions</a> and that you have read our <a href='../seller-play-store-privacy-policy.php' target='_blank' >Privacy & Policy</a>.
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" id="submit_btn" name="btnSignUp" class="btn btn-info">Sign Up</button>
                            <input type="reset" class="btn-warning btn" value="Clear" />
                            <a href="index.php" class="btn pull-right">Back to Login Page?</a>
                        </div>
                        <div class="form-group">
                            <div id="result" style="display: none;"></div>
                        </div>
                    </div>
                </form>
            </div><!-- /.box -->
        </div>
    </div>
</body>

</html>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>

<script>
    $('#add_shop_form').validate({
        rules: {
            name: "required",
            email: "required",
            mobile: "required",
            agreed: "required",
            password: "required",
            confirm_password: {
                required: true,
                equalTo: "#password"
            }
        }
    });
    
</script>
<script>
    $('#add_shop_form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        if ($("#add_shop_form").validate().form()) {
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                beforeSend: function() {
                    $('#submit_btn').html('Please wait..');
                },
                cache: false,
                contentType: false,
                processData: false,
                success: function(result) {
                    $('#result').html(result);
                    $('#result').show().delay(6000).fadeOut();
                    $('#submit_btn').html('Submit');
                    $('#add_shop_form')[0].reset();
                   

                }
            });
        }
    });
</script>