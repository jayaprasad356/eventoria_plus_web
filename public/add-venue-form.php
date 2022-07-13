<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

$sql_query = "SELECT id, name FROM category ORDER BY id ASC";
$db->sql($sql_query);

$res = $db->getResult();
$sql_query = "SELECT value FROM settings WHERE variable = 'Currency'";
$pincode_ids_exc = "";
$db->sql($sql_query);

$res_cur = $db->getResult();
if (isset($_POST['btnAdd'])) {
        $error = array();
        $name = $db->escapeString($fn->xss_clean($_POST['name']));
        $address = $db->escapeString($fn->xss_clean($_POST['address']));
        $price = $db->escapeString($fn->xss_clean($_POST['price']));
        $pincode = $db->escapeString($fn->xss_clean($_POST['pincode']));
        
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
        if (empty($address)) {
            $error['address'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($price)) {
            $error['price'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($pincode)) {
            $error['pincode'] = " <span class='label label-danger'>Required!</span>";
        }

        if (!empty($name)&& !empty($address) && !empty($price) && !empty($pincode))
        {
            $result = $fn->validate_image($_FILES["category_image"]);
            // create random image file name
            $string = '0123456789';
            $file = preg_replace("/\s+/", "_", $_FILES['category_image']['name']);
            $menu_image = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;
    
            // upload new image
            $upload = move_uploaded_file($_FILES['category_image']['tmp_name'], 'upload/images/' . $menu_image);
    
            // insert new data to menu table
            $upload_image = 'upload/images/' . $menu_image;

            $sql = "INSERT INTO venues (name,address,cover_image,price,pincode) VALUES('$name','$address','$upload_image','$price','$pincode')";
            $db->sql($sql);
            $venue_result = $db->getResult();
            if (!empty($venue_result)) {
                $venue_result = 0;
            } else {
                $venue_result = 1;
            }
            if ($venue_result == 1) {
                $sql = "SELECT id FROM venues ORDER BY id DESC LIMIT 1";
                $db->sql($sql);
                $res = $db->getResult();
                $venue_id = $res[0]['id'];
                for ($i = 0; $i < count($_POST['start_time']); $i++) {
    
                    $start_time = $db->escapeString($fn->xss_clean($_POST['start_time'][$i]));
                    $end_time = $db->escapeString($fn->xss_clean($_POST['end_time'][$i]));
                    $prices = $db->escapeString($fn->xss_clean($_POST['prices'][$i]));
                    $sql = "INSERT INTO timeslots (venue_id,start_time,end_time,prices) VALUES('$venue_id','$start_time','$end_time','$prices')";
                    $db->sql($sql);
                    $timeslots_result = $db->getResult();
                }
                if (!empty($timeslots_result)) {
                    $timeslots_result = 0;
                } else {
                    $timeslots_result = 1;
                }
                if($timeslots_result == 1){
                $error['add_menu'] = "<section class='content-header'>
                                                <span class='label label-success'>Venue Added Successfully</span>
                                                <h4><small><a  href='subjects.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Subjects</a></small></h4>
                                                 </section>";
            } else {
                $error['add_menu'] = " <span class='label label-danger'>Failed</span>";
            }

        }
    }
}
?>
<section class="content-header">
    <h1>Add Venue</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Venue</h3>
                </div>
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='add_venue_form' method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                               <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Name</label> <i class="text-danger asterik">*</i> <?php echo isset($error['name']) ? $error['name'] : ''; ?><br>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="form-group">
                               <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Address</label> <i class="text-danger asterik">*</i> <?php echo isset($error['address']) ? $error['address'] : ''; ?><br>
                                    <input type="text" class="form-control" name="address" required>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <label for="exampleInputFile">Image</label><?php echo isset($error['category_image']) ? $error['category_image'] : ''; ?>
                                        <input type="file" name="category_image" onchange="readURL(this);" accept="image/png,  image/jpeg" id="category_image" />
                                        <div class="form-group">
                                            <img id="blah" src="#" alt="image" />

                                        </div>
                                    </div>
                                </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Price</label> <i class="text-danger asterik">*</i><?php echo isset($error['price']) ? $error['price'] : ''; ?>
                                    <input type="text" class="form-control" name="price" required>
                                </div>
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Pincode</label> <i class="text-danger asterik">*</i> <?php echo isset($error['pincode']) ? $error['pincode'] : ''; ?><br>
                                    <input type="text" class="form-control" name="pincode" required>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div id="packate_div"  >
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group packate_div">
                                        <label for="exampleInputEmail1">Start Time</label> <i class="text-danger asterik">*</i>
                                        <input type="time" class="form-control" name="start_time[]" required />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group packate_div">
                                        <label for="exampleInputEmail1">End Time</label> <i class="text-danger asterik">*</i>
                                        <input type="time" class="form-control" name="end_time[]" required />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group packate_div">
                                        <label for="exampleInputEmail1">Price</label> <i class="text-danger asterik">*</i>
                                        <input type="text" class="form-control" name="prices[]" id="packate_price" required />
                                    </div>
                                </div>
                               
                                <div class="col-md-1">
                                    <label>Variation</label>
                                    <a class="add_packate_variation" title="Add variation of product" style="cursor: pointer;"><i class="fa fa-plus-square-o fa-2x"></i></a>
                                </div>
                                <div id="variations">
                                </div>
                            </div>

                        </div>
                        <hr>
                    </div>
                       
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <input type="submit" class="btn-primary btn" value="Add" name="btnAdd" />&nbsp;
                        <input type="reset" class="btn-danger btn" value="Clear" id="btnClear" />
                        <!--<div  id="res"></div>-->
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<div class="separator"> </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
    $('#add_venue_form').validate({

        ignore: [],
        debug: false,
        rules: {
            name: "required",
            address: "required",
            price: "required",
            pincode: "required",
            category_image: "required",
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var max_fields = 8;
        var wrapper = $("#packate_div");
        var add_button = $(".add_packate_variation");

        var x = 1;
        $(add_button).click(function (e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
                $(wrapper).append('<div class="row"><div class="col-md-3"><div class="form-group"><label for="start_time">Start Time</label>' + '<input type="time" class="form-control" name="start_time[]" required="" ></div></div>'+'<div class="col-md-3"><div class="form-group"><label for="end_time">End Time</label>' + '<input type="time" class="form-control" name="end_time[]" required="" ></div></div>'+'<div class="col-md-3"><div class="form-group"><label for="price">Price</label>' + '<input type="text" class="form-control" name="prices[]" required="" ></div></div>' + '<div class="col-md-1" style="display: grid;"><label>Remove</label><a class="remove text-danger" style="cursor: pointer;"><i class="fa fa-times fa-2x"></i></a></div>'+'</div>'); //add input box
            } else {
                alert('You Reached the limits')
            }
        });

        $(wrapper).on("click", ".remove", function (e) {
            e.preventDefault();
            $(this).closest('.row').remove();
            x--;
        })
    });
</script>
<?php $db->disconnect(); ?>