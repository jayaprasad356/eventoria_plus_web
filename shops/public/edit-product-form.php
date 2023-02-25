<?php
include_once('../includes/functions.php');
$function = new functions;
include_once('../includes/custom-functions.php');
$fn = new custom_functions;
?>
<?php
if (isset($_GET['id'])) {
    $ID = $db->escapeString($fn->xss_clean($_GET['id']));
} else {
    // $ID = "";
    return false;
    exit(0);
}
if (isset($_POST['btnEdit'])) {
        
        $name = $db->escapeString($fn->xss_clean($_POST['name']));
        $category = $db->escapeString($fn->xss_clean($_POST['category']));
        $price = $db->escapeString($fn->xss_clean($_POST['price']));
        $measurement = $db->escapeString($fn->xss_clean($_POST['measurement']));
        $unit = $db->escapeString($fn->xss_clean($_POST['unit']));
        $description = $db->escapeString($fn->xss_clean($_POST['description']));
        $pincode = $db->escapeString($fn->xss_clean($_POST['pincode']));
        $status = $db->escapeString($fn->xss_clean($_POST['status']));
        $error = array();

       
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


        if (!empty($name) && !empty($price) && !empty($category) && !empty($description)&& !empty($pincode) && !empty($measurement) && !empty($unit))
         {

    //cover_image
            if ($_FILES['image']['size'] != 0 && $_FILES['image']['error'] == 0 && !empty($_FILES['image']))
            {
				$old_image = $db->escapeString($_POST['old_image']);
				$extension = pathinfo($_FILES["image"]["name"])['extension'];
                $new_image = $ID . "." . $extension;
                
		
				$result = $fn->validate_image($_FILES["image"]);
				$target_path = '../upload/images/';
				
				$filename = microtime(true) . '.' . strtolower($extension);
				$full_path = $target_path . "" . $filename;
				if (!move_uploaded_file($_FILES["image"]["tmp_name"], $full_path)) {
					echo '<p class="alert alert-danger">Can not upload image.</p>';
					return false;
					exit();
				}
				if (!empty($old_image)) {
					unlink( $old_image);
				}
                $upload_image = 'upload/images/' . $filename;
                $sql = "UPDATE products SET product_image='$upload_image' WHERE id =  $ID";
                $db->sql($sql);
			}
//image1
            if ($_FILES['image1']['size'] != 0 && $_FILES['image1']['error'] == 0 && !empty($_FILES['image1']))
            {
				$old_image1 = $db->escapeString($_POST['old_image1']);
				$extension = pathinfo($_FILES["image1"]["name"])['extension'];
                $new_image = $ID . "." . $extension;
                
		
				$result = $fn->validate_image($_FILES["image1"]);
				$target_path = '../upload/images/';
				
				$filename = microtime(true) . '.' . strtolower($extension);
				$full_path = $target_path . "" . $filename;
				if (!move_uploaded_file($_FILES["image1"]["tmp_name"], $full_path)) {
					echo '<p class="alert alert-danger">Can not upload image.</p>';
					return false;
					exit();
				}
				if (!empty($old_image1)) {
					unlink( $old_image1);
				}
                $upload_image1 = 'upload/images/' . $filename;
                $sql = "UPDATE products SET image1='$upload_image1' WHERE id =  $ID";
                $db->sql($sql);
			}

            $sql = "UPDATE products SET name='$name',category_id='$category',measurement='$measurement',unit='$unit',price='$price',description='$description',pincode='$pincode',status='$status' WHERE id =  $ID";
            $db->sql($sql);
            $update_result = $db->getResult();
            if (!empty($update_result)) {
                $update_result = 0;
            } else {
                $update_result = 1;
            }
           	// check update result
			if ($update_result == 1) {
				$error['update_product'] = " <section class='content-header'><span class='label label-success'>Product updated Successfully</span></section>";
			} else {
				$error['update_product'] = " <span class='label label-danger'>Failed update</span>";
			}

        }
    }
// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM products WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();
 ?>
<section class="content-header">
	<h1>
		Edit Product<small><a href='products.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Products</a></small></h1>
	<small><?php echo isset($error['update_product']) ? $error['update_product'] : ''; ?></small>
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
                    <h3 class="box-title">Edit Product</h3>
                </div>
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='edit_package_form' method="post"  enctype="multipart/form-data">
                    <div class="box-body">
                        <input type="hidden" id="old_image" name="old_image"  value="<?= "../" .$res[0]['product_image']; ?>">
                        <input type="hidden" id="old_image1" name="old_image1"  value="<?= "../" .$res[0]['image1']; ?>">
                       
                        <div class="row">
                            <div class="form-group">
                               <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Name</label> <i class="text-danger asterik">*</i><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                    <input type="text" class="form-control" name="name" value="<?php echo $res[0]['name']; ?>">
                                </div>
                                <div class='col-md-4'>
                                    <label for="">category</label><?php echo isset($error['category']) ? $error['category'] : ''; ?>
                                    <select id='category' name="category" class='form-control'>
                                          <option value="">--select--</option>
                                            <?php
                                            $sql = "SELECT * FROM `categories` WHERE status = 1";
                                            $db->sql($sql);
                                            $result = $db->getResult();
                                            foreach ($result as $value) {
                                            ?>
											   <option value='<?= $value['id'] ?>' <?= $value['id']==$res[0]['category_id'] ? 'selected="selected"' : '';?>><?= $value['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                               <div class='col-md-3'>
                                    <label for="exampleInputEmail1">Measurement</label> <i class="text-danger asterik">*</i><?php echo isset($error['measurement']) ? $error['measurement'] : ''; ?>
                                    <input type="text" class="form-control" name="measurement" value="<?php echo $res[0]['measurement']; ?>">
                                </div>
                                <div class='col-md-3'>
                                    <label for="">Unit</label><?php echo isset($error['unit']) ? $error['unit'] : ''; ?>
                                    <select id='unit' name="unit" class='form-control'>
                                          <option value="">--select--</option>
                                            <?php
                                            $sql = "SELECT * FROM `units`";
                                            $db->sql($sql);
                                            $result = $db->getResult();
                                            foreach ($result as $value) {
                                            ?>
											   <option value='<?= $value['unit'] ?>' <?= $value['unit']==$res[0]['unit'] ? 'selected="selected"' : '';?>><?= $value['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class='col-md-3'>
                                    <label for="exampleInputEmail1">Price</label> <i class="text-danger asterik">*</i><?php echo isset($error['price']) ? $error['price'] : ''; ?>
                                    <input type="text" class="form-control" name="price" value="<?php echo $res[0]['price']; ?>">
                                </div>
                                <div class='col-md-3'>
                                    <label for="exampleInputEmail1">Pincode</label> <i class="text-danger asterik">*</i><?php echo isset($error['pincode']) ? $error['pincode'] : ''; ?>
                                    <input type="number" class="form-control" name="pincode" value="<?php echo $res[0]['pincode']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-10">
                                    <label for="exampleInputEmail1">Description</label> <i class="text-danger asterik">*</i>
                                    <textarea type="text" rows="2" class="form-control" name="description"><?php echo $res[0]['description']; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                               <div class='col-md-4'>
                                       <label for="exampleInputFile">Cover Image</label> <i class="text-danger asterik">*</i>
                                        <input type="file" accept="image/png,  image/jpeg" onchange="readURL(this);"  name="image" id="image">
                                        <p class="help-block"><img id="blah" src="<?php echo "../" . $res[0]['product_image']; ?>" style="max-width:100%" /></p>
                                </div>
                                <div class='col-md-4'>
                                       <label for="exampleInputFile">Image1</label>
                                        <input type="file" accept="image/png,  image/jpeg" name="image1" id="image1">
                                        <p class="help-block"><img id="blah" src="<?php echo "../". $res[0]['image1']; ?>" style="max-width:100%" /></p>
                                </div>
                                <div class='col-md-4'>
                                        <label class="control-label">Status</label> <i class="text-danger asterik">*</i><br>
                                        <div id="status" class="btn-group">
                                            <label class="btn btn-danger" data-toggle-class="btn-default" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="status" value="0" <?= ($res[0]['status'] == 0) ? 'checked' : ''; ?>> Unavailable
                                            </label>
                                            <label class="btn btn-success" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="status" value="1" <?= ($res[0]['status'] == 1) ? 'checked' : ''; ?>> Available
                                            </label>
                                        </div>
						        </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
						<button type="submit" class="btn btn-primary" name="btnEdit">Update</button>
					
					</div>
                </form>
            </div>
            <!-- /.box -->
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
<?php $db->disconnect(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>