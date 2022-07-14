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
        $pincode = $db->escapeString($fn->xss_clean($_POST['pincode']));
        
        // get image info
        $menu_image = $db->escapeString($_FILES['category_image']['name']);
        $image_error = $db->escapeString($_FILES['category_image']['error']);
        $image_type = $db->escapeString($_FILES['category_image']['type']);

        //image1 info
        $menu_image = $db->escapeString($_FILES['image1']['name']);
        $image_error = $db->escapeString($_FILES['image1']['error']);
        $image_type = $db->escapeString($_FILES['image1']['type']);

        //image2 info
        $menu_image = $db->escapeString($_FILES['image2']['name']);
        $image_error = $db->escapeString($_FILES['image2']['error']);
        $image_type = $db->escapeString($_FILES['image2']['type']);

        //image3 info
        $menu_image = $db->escapeString($_FILES['image3']['name']);
        $image_error = $db->escapeString($_FILES['image3']['error']);
        $image_type = $db->escapeString($_FILES['image3']['type']);

        //image4 info
        $menu_image = $db->escapeString($_FILES['image4']['name']);
        $image_error = $db->escapeString($_FILES['image4']['error']);
        $image_type = $db->escapeString($_FILES['image4']['type']);

        // create array variable to handle error
        $error = array();
            // common image file extensions
        $allowedExts = array("gif", "jpeg", "jpg", "png");

        // get image file extension
        error_reporting(E_ERROR | E_PARSE);
        $extension = end(explode(".", $_FILES["category_image"]["name"]));

         //get image1 file extension
         error_reporting(E_ERROR | E_PARSE);
         $extension = end(explode(".", $_FILES["image1"]["name"]));
 
         //get image2 file extension
         error_reporting(E_ERROR | E_PARSE);
         $extension = end(explode(".", $_FILES["image2"]["name"]));
 
         //get image3 file extension
         error_reporting(E_ERROR | E_PARSE);
         $extension = end(explode(".", $_FILES["image3"]["name"]));
 
         //get image4 file extension
         error_reporting(E_ERROR | E_PARSE);
         $extension = end(explode(".", $_FILES["image4"]["name"]));
 


       
        if (empty($name)) {
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($address)) {
            $error['address'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($pincode)) {
            $error['pincode'] = " <span class='label label-danger'>Required!</span>";
        }

        if (!empty($name)&& !empty($address)&& !empty($pincode))
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
            $upload_image1 ='';
            $upload_image2 ='';
            $upload_image3 ='';
            $upload_image4 ='';
            if ($_FILES['image1']['size'] != 0 && $_FILES['image1']['error'] == 0 && !empty($_FILES['image1'])){

 //image1 info
                // create random image1 file name
                $string = '0123456789';
                $file = preg_replace("/\s+/", "_", $_FILES['image1']['name']);
                $image1 = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;

                //upload new image1
                $upload = move_uploaded_file($_FILES['image1']['tmp_name'], 'upload/images/' . $image1);

                // insert new data to menu table
                $upload_image1 = 'upload/images/' . $image1;

            }
            if ($_FILES['image2']['size'] != 0 && $_FILES['image2']['error'] == 0 && !empty($_FILES['image2'])){
                
//image2 info

            // create random image2 file name
            $string = '0123456789';
            $file = preg_replace("/\s+/", "_", $_FILES['image2']['name']);
            $image2 = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;

            //upload new image2
            $upload = move_uploaded_file($_FILES['image2']['tmp_name'], 'upload/images/' . $image2);

            // insert new data to menu table
            $upload_image2 = 'upload/images/' . $image2;

            }
            if ($_FILES['image3']['size'] != 0 && $_FILES['image3']['error'] == 0 && !empty($_FILES['image3'])){
 //image3 info
            // create random image3 file name
            $string = '0123456789';
            $file = preg_replace("/\s+/", "_", $_FILES['image3']['name']);
            $image3 = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;

            //upload new image3
            $upload = move_uploaded_file($_FILES['image3']['tmp_name'], 'upload/images/' . $image3);

            // insert new data to menu table
            $upload_image3 = 'upload/images/' . $image3;

            }
            if ($_FILES['image3']['size'] != 0 && $_FILES['image3']['error'] == 0 && !empty($_FILES['image3'])){
                
 //image4 info
            // create random image4 file name
            $string = '0123456789';
            $file = preg_replace("/\s+/", "_", $_FILES['image4']['name']);
            $image4 = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;

            //upload new image4
            $upload = move_uploaded_file($_FILES['image4']['tmp_name'], 'upload/images/' . $image4);

            // insert new data to menu table
            $upload_image4 = 'upload/images/' . $image4;
            }

            $sql = "INSERT INTO venues (name,address,cover_image,image1,image2,image3,image4,pincode) VALUES('$name','$address','$upload_image','$upload_image1','$upload_image2','$upload_image3','$upload_image4','$pincode')";
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
                
                $error['add_menu'] = "<section class='content-header'>
                                                <span class='label label-success'>Venue Added Successfully</span>
                                                <h4><small><a  href='venues.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Venues</a></small></h4>
                                                 </section>";
            } else {
                $error['add_menu'] = " <span class='label label-danger'>Failed</span>";
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
                            <div class="form-group">
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Pincode</label> <i class="text-danger asterik">*</i> <?php echo isset($error['pincode']) ? $error['pincode'] : ''; ?><br>
                                    <input type="text" class="form-control" name="pincode" required>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <label for="exampleInputFile">Cover Photo</label><i class="text-danger asterik">*</i><?php echo isset($error['category_image']) ? $error['category_image'] : ''; ?>
                                        <input type="file" name="category_image" onchange="readURL(this);" accept="image/png,  image/jpeg" id="category_image" required/>
                                        <div class="form-group">
                                            <img id="blah" src="#" alt="image" />

                                        </div>
                                    </div>
                                </div>
                        </div>
                        <hr>
                        <div class="row">
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label for="exampleInputFile">Image1</label><?php echo isset($error['image1']) ? $error['image1'] : ''; ?>
                                        <input type="file" name="image1" onchange="readURL(this);" accept="image/png,  image/jpeg" id="image1" />
                                        <div class="form-group">
                                            <img id="blah" src="#" alt="image" />

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="exampleInputFile">Image2</label><?php echo isset($error['image2']) ? $error['image2'] : ''; ?>
                                        <input type="file" name="image2" onchange="readURL(this);" accept="image/png,  image/jpeg" id="image2"/>
                                        <div class="form-group">
                                            <img id="blah" src="#" alt="image" />

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="exampleInputFile">Image3</label><?php echo isset($error['image3']) ? $error['image3'] : ''; ?>
                                        <input type="file" name="image3" onchange="readURL(this);" accept="image/png,  image/jpeg" id="image3" />
                                        <div class="form-group">
                                            <img id="blah" src="#" alt="image" />

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="exampleInputFile">Image4</label><?php echo isset($error['image4']) ? $error['image4'] : ''; ?>
                                        <input type="file" name="image4" onchange="readURL(this);" accept="image/png,  image/jpeg" id="image4" />
                                        <div class="form-group">
                                            <img id="blah" src="#" alt="image" />

                                        </div>
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