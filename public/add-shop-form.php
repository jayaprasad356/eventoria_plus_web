<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

?>
<?php
if (isset($_POST['btnAdd'])) {


        $name = $db->escapeString($fn->xss_clean($_POST['name']));
        $shop_name = $db->escapeString($fn->xss_clean($_POST['shop_name']));
        $email = $db->escapeString($fn->xss_clean($_POST['email']));
        $mobile = $db->escapeString($fn->xss_clean($_POST['mobile']));
        $password = $db->escapeString($fn->xss_clean($_POST['password']));
        $pincode = $db->escapeString($fn->xss_clean($_POST['pincode']));
        $street = $db->escapeString($fn->xss_clean($_POST['street']));
        $state = $db->escapeString($fn->xss_clean($_POST['state']));
        $account_number = (isset($_POST['account_number']) && !empty($_POST['account_number'])) ? trim($db->escapeString($fn->xss_clean($_POST['account_number']))) : "";
        $bank_ifsc_code = (isset($_POST['bank_ifsc_code']) && !empty($_POST['bank_ifsc_code'])) ? trim($db->escapeString($fn->xss_clean($_POST['bank_ifsc_code']))) : "";
        $holder_name = (isset($_POST['holder_name']) && !empty($_POST['holder_name'])) ? trim($db->escapeString($fn->xss_clean($_POST['holder_name']))) : "";
        $bank_name = (isset($_POST['bank_name']) && !empty($_POST['bank_name'])) ? trim($db->escapeString($fn->xss_clean($_POST['bank_name']))) : "";
        $latitude = $db->escapeString($fn->xss_clean($_POST['latitude']));
        $longitude = $db->escapeString($fn->xss_clean($_POST['longitude']));
        $balance = (isset($_POST['balance']) && !empty($_POST['balance'])) ? trim($db->escapeString($fn->xss_clean($_POST['balance']))) : 0;

        // get image info
        $menu_image = $db->escapeString($_FILES['category_image']['name']);
        $image_error = $db->escapeString($_FILES['category_image']['error']);
        $image_type = $db->escapeString($_FILES['category_image']['type']);

        // create array variable to handle error
        $error = array();
            // common image file extensions
        $allowedExts = array("gif", "jpeg", "jpg", "png");

        // get image file extension
        error_reporting(E_ERROR | E_PARSE);
        $extension = end(explode(".", $_FILES["category_image"]["name"]));
        

        if (empty($name)) {
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($shop_name)) {
            $error['shop_name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($email)) {
            $error['email'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($mobile)) {
            $error['mobile'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($password)) {
            $error['password'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($street)) {
            $error['street'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($pincode)) {
            $error['pincode'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($state)) {
            $error['state'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($latitude)) {
            $error['latitude'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($longitude)) {
            $error['longitude'] = " <span class='label label-danger'>Required!</span>";
        }
       
       

      

        if (!empty($name) && !empty($shop_name) && !empty($email) && !empty($mobile) && !empty($password) && !empty($latitude) && !empty($longitude) && !empty($pincode)) {
            $result = $fn->validate_image($_FILES["category_image"]);
                // create random image file name
                $string = '0123456789';
                $file = preg_replace("/\s+/", "_", $_FILES['category_image']['name']);
                $menu_image = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;
        
                // upload new image
                $upload = move_uploaded_file($_FILES['category_image']['tmp_name'], 'upload/shops/' . $menu_image);
        
                // insert new data to menu table
                $upload_image = $menu_image;

            
           
            $sql_query = "INSERT INTO `shops` (name,shop_name,email,mobile,password,pincode,street,state,latitude,longitude,account_number,bank_ifsc_code,holder_name,bank_name,logo,balance,status)VALUES('$name','$shop_name','$email','$mobile','$password','$pincode','$street','$state','$latitude','$longitude','$account_number','$bank_ifsc_code','$holder_name','$bank_name','$upload_image','$balance',0)";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                $error['add_shop'] = " <section class='content-header'><span class='label label-success'>Shop Added Successfully</span></section>";
            } else {
                $error['add_shop'] = " <span class='label label-danger'>Failed add Shop</span>";
            }
            }
        }
?>
<section class="content-header">
    <h1>Add Shop <small><a href='shops.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Shops</a></small></h1>

    <?php echo isset($error['add_shop']) ? $error['add_shop'] : ''; ?>
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
                    <h3 class="box-title">Add Shop</h3>

                </div><!-- /.box-header -->
                <!-- form start -->
                <form name="add_shop_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-5">
                                    <label for="exampleInputEmail1"> Name</label> <i class="text-danger asterik">*</i><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="col-md-5">
                                    <label for="exampleInputEmail1"> Shop Name</label> <i class="text-danger asterik">*</i><?php echo isset($error['shop_name']) ? $error['shop_name'] : ''; ?>
                                    <input type="text" class="form-control" name="shop_name" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                               <div class="col-md-4">
                                    <label for="exampleInputEmail1">Mobile Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['mobile']) ? $error['mobile'] : ''; ?>
                                    <input type="number" class="form-control" name="mobile" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1"> Email Id</label> <i class="text-danger asterik">*</i><?php echo isset($error['email']) ? $error['email'] : ''; ?>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Password</label> <i class="text-danger asterik">*</i><?php echo isset($error['password']) ? $error['password'] : ''; ?>
                                    <input type="text" class="form-control" name="password" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                               <div class="col-md-4">
                                    <label for="exampleInputEmail1">Pincode</label> <i class="text-danger asterik">*</i><?php echo isset($error['pincode']) ? $error['pincode'] : ''; ?>
                                    <input type="number" class="form-control" name="pincode" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Street</label> <i class="text-danger asterik">*</i><?php echo isset($error['street']) ? $error['street'] : ''; ?>
                                    <input type="text" class="form-control" name="street" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">State</label> <i class="text-danger asterik">*</i><?php echo isset($error['state']) ? $error['state'] : ''; ?>
                                    <input type="text" class="form-control" name="state" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                               <div class="col-md-3">
                                    <label for="exampleInputEmail1">Account Number</label> 
                                    <input type="number" class="form-control" name="account_number">
                                </div>
                                <div class="col-md-3">
                                    <label for="exampleInputEmail1">IFSC Code</label>
                                    <input type="text" class="form-control" name="bank_ifsc_code">
                                </div>
                                <div class="col-md-3">
                                    <label for="exampleInputEmail1">Account Holder Name</label>
                                    <input type="text" class="form-control" name="holder_name">
                                </div>
                                <div class="col-md-3">
                                    <label for="exampleInputEmail1">Bank Name</label> 
                                    <input type="text" class="form-control" name="bank_name">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                               <div class="col-md-4">
                                    <label for="exampleInputEmail1">Latitude</label> <i class="text-danger asterik">*</i><?php echo isset($error['latitude']) ? $error['latitude'] : ''; ?>
                                    <input type="text" class="form-control" name="latitude" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Longitude</label> <i class="text-danger asterik">*</i><?php echo isset($error['longitude']) ? $error['longitude'] : ''; ?>
                                    <input type="text" class="form-control" name="longitude" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Balance</label>
                                    <input type="number" class="form-control" name="balance">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="exampleInputFile">Image</label> <i class="text-danger asterik">*</i><?php echo isset($error['category_image']) ? $error['category_image'] : ''; ?>
                            <input type="file" name="category_image" onchange="readURL(this);" accept="image/png,  image/jpeg" id="category_image" />
                        </div>
                        <div class="form-group">
                            <img id="blah" src="#" alt="image" />
                        </div>
                    </div>
                  
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnAdd">Add</button>
                        <input type="reset" onClick="refreshPage()" class="btn-warning btn" value="Clear" />
                    </div>

                </form>

            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
    $('#add_shop_form').validate({

        ignore: [],
        debug: false,
        rules: {
            name: "required",
            shop_name: "required",
            mobile: "required",
            email: "required",
            password: "required",
            pincode: "required",
            street: "required",
            latitude: "required",
            longitude: "required",

        }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
</script>
<script>
    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>

<!--code for page clear-->
<script>
    function refreshPage(){
    window.location.reload();
} 
</script>
<?php $db->disconnect(); ?>