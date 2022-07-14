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
        $price = $db->escapeString($fn->xss_clean($_POST['price']));
        $category = $db->escapeString($fn->xss_clean($_POST['category']));
        $description = $db->escapeString($fn->xss_clean($_POST['description']));
        $pincode = $db->escapeString($fn->xss_clean($_POST['pincode']));
        $recommend= $db->escapeString($fn->xss_clean($_POST['recommend']));

        // get cover_image info
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
        if (empty($price)) {
            $error['price'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($category)) {
            $error['category'] = " <span class='label label-danger'>Required!</span>";
        }

        if (empty($description)) {
            $error['description'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($pincode)) {
            $error['pincode'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($recommend)) {
            $error['recommend'] = " <span class='label label-danger'>Required!</span>";
        }

        if (!empty($name) && !empty($price) && !empty($category) && !empty($description)&& !empty($pincode)&& !empty($recommend))
        {

//cover_image
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
            $sql = "INSERT INTO packages (name,cover_photo,image1,image2,image3,image4,price,category_id,description,pincode,recommend,status) VALUES('$name','$upload_image','$upload_image1','$upload_image2','$upload_image3','$upload_image4','$price','$category','$description','$pincode','$recommend',1)";
            $db->sql($sql);
            $package_result = $db->getResult();
            if (!empty($package_result)) {
                $package_result = 0;
            } else {
                $package_result = 1;
            }
            if ($package_result == 1) {
                $error['add_menu'] = "<section class='content-header'>
                                                <span class='label label-success'>Package Added Successfully</span>
                                                <h4><small><a  href='packages.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Packages</a></small></h4>
                                                 </section>";
            } else {
                $error['add_menu'] = " <span class='label label-danger'>Failed</span>";
            }

        }
    }
?>
<section class="content-header">
    <h1>Add Package</h1>
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
                    <h3 class="box-title">Add Package</h3>
                </div>
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='add_package_form' method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                               <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Name</label> <i class="text-danger asterik">*</i> <?php echo isset($error['name']) ? $error['name'] : ''; ?><br>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
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
                                        <label for="exampleInputFile">Cover Image</label><i class="text-danger asterik">*</i><?php echo isset($error['image']) ? $error['image'] : ''; ?>
                                        <input type="file" name="category_image" onchange="readURL(this);" accept="image/png,  image/jpeg" id="category_image" required/>
                                        <div class="form-group">
                                            <img id="blah" src="#" alt="image" />

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="exampleInputFile">Image1</label><?php echo isset($error['image1']) ? $error['image1'] : ''; ?>
                                        <input type="file" name="image1" onchange="readURL(this);" accept="image/png,  image/jpeg" id="image1" />
                                        <div class="form-group">
                                            <img id="blah" src="#" alt="image" />

                                        </div>
                                    </div>
                                </div>
                        </div>
                        <hr>
                        <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <label for="exampleInputFile">Image2</label><?php echo isset($error['image2']) ? $error['image2'] : ''; ?>
                                        <input type="file" name="image2" onchange="readURL(this);" accept="image/png,  image/jpeg" id="image2"/>
                                        <div class="form-group">
                                            <img id="blah" src="#" alt="image" />

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="exampleInputFile">Image3</label><?php echo isset($error['image3']) ? $error['image3'] : ''; ?>
                                        <input type="file" name="image3" onchange="readURL(this);" accept="image/png,  image/jpeg" id="image3" />
                                        <div class="form-group">
                                            <img id="blah" src="#" alt="image" />

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="exampleInputFile">Image4</label><?php echo isset($error['image4']) ? $error['image4'] : ''; ?>
                                        <input type="file" name="image4" onchange="readURL(this);" accept="image/png,  image/jpeg" id="image4" />
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
                                    <label for="">category</label>
                                    <select id='category' name="category" class='form-control'>
                                            <?php
                                            $sql = "SELECT * FROM `categories`WHERE status=1";
                                            $db->sql($sql);
                                            $result = $db->getResult();
                                            foreach ($result as $value) {
                                            ?>
                                                  <option value='<?= $value['id'] ?>'><?= $value['name'] ?></option>
                                        <?php } ?>
                                        </select>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="form-group">
                               <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Description</label> <i class="text-danger asterik">*</i> <?php echo isset($error['description']) ? $error['description'] : ''; ?><br>
                                    <textarea type="text" class="form-control" name="description" required></textarea>
                                </div>
                                <div class='col-md-4'>
                                     <label class="control-label">Recommend</label>
                                     <div id="recommend" class="form-group">
                                        <label class="btn btn-default" data-toggle-class="btn-default" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="recommend" value="1"> Yes
                                        </label>
                                        <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="recommend" value="0"> No
                                        </label>
                                     </div>
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
<script>
    $('#add_package_form').validate({

        ignore: [],
        debug: false,
        rules: {
            name: "required",
            price: "required",
            description: "required",
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
<?php $db->disconnect(); ?>