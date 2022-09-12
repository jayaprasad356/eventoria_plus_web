<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

?>
<?php
if (isset($_POST['btnAdd'])) {


        $name = $db->escapeString($fn->xss_clean($_POST['name']));
        $type = $db->escapeString($fn->xss_clean($_POST['type']));
        $link = (isset($_POST['link']) && !empty($_POST['link'])) ? trim($db->escapeString($fn->xss_clean($_POST['link']))) : "";
        $category = (isset($_POST['category']) && !empty($_POST['category'])) ? trim($db->escapeString($fn->xss_clean($_POST['category']))) : "";
        $package = (isset($_POST['package']) && !empty($_POST['package'])) ? trim($db->escapeString($fn->xss_clean($_POST['package']))) : "";
        //$id = ($type != 'none') ? $db->escapeString($fn->xss_clean($_POST[$type])) : "0";
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
        if (empty($type)) {
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($status)) {
            $error['status'] = " <span class='label label-danger'>Required!</span>";
        }
     
       

      

        if (!empty($name) && !empty($type)) {
            $result = $fn->validate_image($_FILES["category_image"]);
                // create random image file name
                $string = '0123456789';
                $file = preg_replace("/\s+/", "_", $_FILES['category_image']['name']);
                $menu_image = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;
        
                // upload new image
                $upload = move_uploaded_file($_FILES['category_image']['tmp_name'], 'upload/images/' . $menu_image);
        
                // insert new data to menu table
                $upload_image = 'upload/images/' . $menu_image;

            
             if($type=='Category'){
                $sql_query = "INSERT INTO slides (name,image,type,category_id,status)VALUES('$name','$upload_image','$type','$category',1)";
                $db->sql($sql_query);
             }
             elseif($type=='Package'){
                $sql_query = "INSERT INTO slides (name,image,type,package_id,status)VALUES('$name','$upload_image','$type','$package',1)";
                $db->sql($sql_query);
             }
             elseif ($type=='External Link') {
                $sql_query = "INSERT INTO slides (name,image,type,link,status)VALUES('$name','$upload_image','$type','$link',1)";
                $db->sql($sql_query);
             }
             else {
                $sql_query = "INSERT INTO slides (name,image,status)VALUES('$name','$upload_image',1)";
                $db->sql($sql_query);
             }
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                $error['add_slide'] = " <section class='content-header'><span class='label label-success'>Slide Added Successfully</span></section>";
            } else {
                $error['add_slide'] = " <span class='label label-danger'>Failed add slide</span>";
            }
            }
        }
?>
<section class="content-header">
    <h1>Add Slide<small><a href='slides.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Slides</a></small></h1>

    <?php echo isset($error['add_slide']) ? $error['add_slide'] : ''; ?>
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
                    <h3 class="box-title">Add Slide</h3>

                </div><!-- /.box-header -->
                <!-- form start -->
                <form name="add_slide" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1"> Name</label><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="type">Type</label>
                              <select  name="type" id="type" class="form-control" required>
                                     <option value="none">Select Type</option>
                                    <option value="Category">Category</option>
                                    <option value="Package">Package</option>
                                    <option value="External Link">External Link</option>
                              </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Image</label><?php echo isset($error['category_image']) ? $error['category_image'] : ''; ?>
                            <input type="file" name="category_image" onchange="readURL(this);" accept="image/png,  image/jpeg" id="category_image" />
                        </div>
                        <div class="form-group">
                            <img id="blah" src="#" alt="image" />

                        </div>
                        <div class="form-group"id="link" style="display: none">
                                        <label for="exampleInputEmail1">Link</label><?php echo isset($error['link']) ? $error['link'] : ''; ?>
                                        <input type="text" class="form-control" name="link" >
                        </div>
                        <div class="form-group" id="categories" style="display: none">
                                        <label for="category">Category</label>
                                        <select id='category' name="category" class='form-control'>
                                                 <option value="">Select Category</option>
                                                    <?php
                                                    $sql = "SELECT * FROM `categories`";
                                                    $db->sql($sql);
                                                    $categories_result = $db->getResult();
                                                    foreach ($categories_result as $value) {
                                                    ?>
                                                        <option value='<?= $value['id'] ?>'><?= $value['name'] ?></option>
                                                <?php } ?>
                                        </select>
                        </div>
                        <div class="form-group" id="packages" style="display: none">
                                        <label for="package">Package</label>
                                        <select id='package' name="package" class='form-control'>
                                              <option value="">Select Package</option>
                                                    <?php
                                                    $sql = "SELECT * FROM `packages`";
                                                    $db->sql($sql);
                                                    $packages_result = $db->getResult();
                                                    foreach ($packages_result as $value) {
                                                    ?>
                                                        <option value='<?= $value['id'] ?>'><?= $value['name'] ?></option>
                                                <?php } ?>
                                        </select>
                                    <div>
                        </div>
                       
                    </div>
                  
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnAdd">Add</button>
                        <input type="reset" class="btn-warning btn" value="Clear" />
                    </div>

                </form>

            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>
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
<script>

$("#type").change(function() {
        type = $("#type").val();
        if(type == "none"){
            $("#categories").hide();
            $("#packages").hide();
            $("#link").hide();
        }
        if(type == "Category"){
            $("#categories").show();
            $("#packages").hide();
            $("#link").hide();

        }
        if(type == "Package"){
            $("#categories").hide();
            $("#packages").show();
            $("#link").hide();
        }
        if(type == "External Link"){
            $("#categories").hide();
            $("#packages").hide();
            $("#link").show();
        }
    });



</script>
<?php $db->disconnect(); ?>