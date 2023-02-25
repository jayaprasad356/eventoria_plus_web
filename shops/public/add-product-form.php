<?php
include_once('../includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('../includes/custom-functions.php');
$fn = new custom_functions;

$sql_query = "SELECT id, name FROM categories ORDER BY id ASC";
$db->sql($sql_query);

$res = $db->getResult();
// $sql_query = "SELECT value FROM settings WHERE variable = 'Currency'";
// $pincode_ids_exc = "";
// $db->sql($sql_query);
// $res_cur = $db->getResult();

if (isset($_POST['btnAdd'])) {
        $error = array();
        $ID = $_SESSION['seller_id'];
        $name = $db->escapeString($fn->xss_clean($_POST['name']));
        $category = $db->escapeString($fn->xss_clean($_POST['category']));
        $price = $db->escapeString($fn->xss_clean($_POST['price']));
        $measurement = $db->escapeString($fn->xss_clean($_POST['measurement']));
        $unit = $db->escapeString($fn->xss_clean($_POST['unit']));
        $description = $db->escapeString($fn->xss_clean($_POST['description']));
        $pincode = $db->escapeString($fn->xss_clean($_POST['pincode']));

        // get cover_image info
        $menu_image = $db->escapeString($_FILES['category_image']['name']);
        $image_error = $db->escapeString($_FILES['category_image']['error']);
        $image_type = $db->escapeString($_FILES['category_image']['type']);

        //image1 info
        $menu_image = $db->escapeString($_FILES['image1']['name']);
        $image_error = $db->escapeString($_FILES['image1']['error']);
        $image_type = $db->escapeString($_FILES['image1']['type']);


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


       
        if (empty($name)) {
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($category)) {
            $error['category'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($price)) {
            $error['price'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($measurement)) {
            $error['measurement'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($unit)) {
            $error['unit'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($description)) {
            $error['description'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($pincode)) {
            $error['pincode'] = " <span class='label label-danger'>Required!</span>";
        }

        if (!empty($name) && !empty($price) && !empty($category) && !empty($description)&& !empty($pincode) && !empty($measurement) && !empty($unit))
        {

//cover_image
            $result = $fn->validate_image($_FILES["category_image"]);
            // create random image file name
            $string = '0123456789';
            $file = preg_replace("/\s+/", "_", $_FILES['category_image']['name']);
            $menu_image = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;
    
            // upload new image
            $upload = move_uploaded_file($_FILES['category_image']['tmp_name'], '../upload/images/' . $menu_image);
    
            // insert new data to menu table
            $upload_image = 'upload/images/' . $menu_image;
            $upload_image1 ='';
            
            if ($_FILES['image1']['size'] != 0 && $_FILES['image1']['error'] == 0 && !empty($_FILES['image1'])){
                
    //image1 info
                // create random image1 file name
                $string = '0123456789';
                $file = preg_replace("/\s+/", "_", $_FILES['image1']['name']);
                $image1 = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;

                //upload new image1
                $upload = move_uploaded_file($_FILES['image1']['tmp_name'], '../upload/images/' . $image1);

                // insert new data to menu table
                $upload_image1 = 'upload/images/' . $image1;

            }
            $sql = "INSERT INTO products (name,seller_id,category_id,measurement,unit,price,description,pincode,product_image,image1,status) VALUES('$name','$ID','$category','$measurement','$unit','$price','$description','$pincode','$upload_image','$upload_image1',1)";
            $db->sql($sql);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }
            if ($result == 1) {
                $error['add_menu'] = "<section class='content-header'>
                                                <span class='label label-success'>Product Added Successfully</span>
                                                <h4><small><a  href='products.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Products</a></small></h4>
                                                 </section>";
            } else {
                $error['add_menu'] = " <span class='label label-danger'>Failed</span>";
            }

        }
    }
?>
<section class="content-header">
    <h1>Add Product</h1>
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
                    <h3 class="box-title">Add Product</h3>
                </div>
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='add_product_form' method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                               <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Name</label> <i class="text-danger asterik">*</i> <?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class='col-md-4'>
                                    <label for="">category</label><i class="text-danger asterik">*</i> 
                                    <select id='category' name="category" class='form-control' required>
                                       <option value="">--Select--</option>
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
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-3'>
                                    <label for="exampleInputEmail1">Measurement</label> <i class="text-danger asterik">*</i> <?php echo isset($error['measurement']) ? $error['measurement'] : ''; ?>
                                    <input type="text" class="form-control" name="measurement" required>
                                </div>
                                <div class='col-md-3'>
                                    <label for="">Unit</label><i class="text-danger asterik">*</i> 
                                    <select id='unit' name="unit" class='form-control' required>
                                            <?php
                                            $sql = "SELECT * FROM `units`";
                                            $db->sql($sql);
                                            $result = $db->getResult();
                                            foreach ($result as $value) {
                                            ?>
                                                  <option value='<?= $value['unit'] ?>'><?= $value['name'] ?></option>
                                        <?php } ?>
                                        </select>
                                </div>
                                <div class='col-md-3'>
                                    <label for="exampleInputEmail1">Price</label> <i class="text-danger asterik">*</i> <?php echo isset($error['price']) ? $error['price'] : ''; ?>
                                    <input type="text" class="form-control" name="price" required>
                                </div>
                                <div class='col-md-3'>
                                    <label for="exampleInputEmail1">Pincode</label> <i class="text-danger asterik">*</i> <?php echo isset($error['pincode']) ? $error['pincode'] : ''; ?>
                                    <input type="text" class="form-control" name="pincode" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-10">
                                    <label for="exampleInputEmail1">Description</label> <i class="text-danger asterik">*</i> <?php echo isset($error['description']) ? $error['description'] : ''; ?>
                                    <textarea type="text" rows="2" class="form-control" name="description" required></textarea>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="exampleInputFile">Product Image</label><i class="text-danger asterik">*</i><?php echo isset($error['image']) ? $error['image'] : ''; ?>
                                    <input type="file" name="category_image" onchange="readURL(this);" accept="image/png,  image/jpeg" id="category_image" required/>
                                    <div class="form-group">
                                        <img id="blah" src="#" alt="image" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputFile">Image1</label><?php echo isset($error['image1']) ? $error['image1'] : ''; ?>
                                    <input type="file" name="image1"  accept="image/png,  image/jpeg" id="image1" />
                                    <div class="form-group">
                                        <img id="blah" src="#" alt="image" />
                                    </div>
                                </div>
                            </div>
                        </div>
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
    $('#add_product_form').validate({

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