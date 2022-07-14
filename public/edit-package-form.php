<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
?>
<?php
// $ID = (isset($_GET['id'])) ? $db->escapeString($fn->xss_clean($_GET['id'])) : "";
if (isset($_GET['id'])) {
    $ID = $db->escapeString($fn->xss_clean($_GET['id']));
} else {
    // $ID = "";
    return false;
    exit(0);
}
if (isset($_POST['btnEdit'])) {
        
        $name = $db->escapeString($fn->xss_clean($_POST['name']));
        $price = $db->escapeString($fn->xss_clean($_POST['price']));
        $category = $db->escapeString($fn->xss_clean($_POST['category']));
        $description = $db->escapeString($fn->xss_clean($_POST['description']));
        $pincode = $db->escapeString($fn->xss_clean($_POST['pincode']));
        $status = $db->escapeString($fn->xss_clean($_POST['status']));
        $recommend = $db->escapeString($fn->xss_clean($_POST['recommend']));
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


        if (!empty($name) && !empty($price) && !empty($category) && !empty($description)&& !empty($pincode))
         {

    //cover_image
            if ($_FILES['image']['size'] != 0 && $_FILES['image']['error'] == 0 && !empty($_FILES['image']))
            {
				$old_image = $db->escapeString($_POST['old_image']);
				$extension = pathinfo($_FILES["image"]["name"])['extension'];
                $new_image = $ID . "." . $extension;
                
		
				$result = $fn->validate_image($_FILES["image"]);
				$target_path = 'upload/images/';
				
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
                $sql = "UPDATE packages SET cover_photo='$upload_image' WHERE id =  $ID";
                $db->sql($sql);
			}
//image1
            if ($_FILES['image1']['size'] != 0 && $_FILES['image1']['error'] == 0 && !empty($_FILES['image1']))
            {
				$old_image = $db->escapeString($_POST['old_image']);
				$extension = pathinfo($_FILES["image1"]["name"])['extension'];
                $new_image = $ID . "." . $extension;
                
		
				$result = $fn->validate_image($_FILES["image1"]);
				$target_path = 'upload/images/';
				
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
                $sql = "UPDATE packages SET image1='$upload_image1' WHERE id =  $ID";
                $db->sql($sql);
			}

//image2
            if ($_FILES['image2']['size'] != 0 && $_FILES['image2']['error'] == 0 && !empty($_FILES['image2']))
            {
				$old_image = $db->escapeString($_POST['old_image']);
				$extension = pathinfo($_FILES["image2"]["name"])['extension'];
                $new_image = $ID . "." . $extension;
                
		
				$result = $fn->validate_image($_FILES["image2"]);
				$target_path = 'upload/images/';
				
				$filename = microtime(true) . '.' . strtolower($extension);
				$full_path = $target_path . "" . $filename;
				if (!move_uploaded_file($_FILES["image2"]["tmp_name"], $full_path)) {
					echo '<p class="alert alert-danger">Can not upload image.</p>';
					return false;
					exit();
				}
				if (!empty($old_image2)) {
					unlink( $old_image2);
				}
                $upload_image2 = 'upload/images/' . $filename;
                $sql = "UPDATE packages SET image2='$upload_image2' WHERE id =  $ID";
                $db->sql($sql);
			}
//image3

            if ($_FILES['image3']['size'] != 0 && $_FILES['image3']['error'] == 0 && !empty($_FILES['image3']))
            {
				$old_image = $db->escapeString($_POST['old_image']);
				$extension = pathinfo($_FILES["image3"]["name"])['extension'];
                $new_image = $ID . "." . $extension;
                
		
				$result = $fn->validate_image($_FILES["image3"]);
				$target_path = 'upload/images/';
				
				$filename = microtime(true) . '.' . strtolower($extension);
				$full_path = $target_path . "" . $filename;
				if (!move_uploaded_file($_FILES["image3"]["tmp_name"], $full_path)) {
					echo '<p class="alert alert-danger">Can not upload image.</p>';
					return false;
					exit();
				}
				if (!empty($old_image3)) {
					unlink( $old_image3);
				}
                $upload_image3 = 'upload/images/' . $filename;
                $sql = "UPDATE packages SET image3='$upload_image3' WHERE id =  $ID";
                $db->sql($sql);
			}

//image4
            if ($_FILES['image4']['size'] != 0 && $_FILES['image4']['error'] == 0 && !empty($_FILES['image4']))
            {
				$old_image = $db->escapeString($_POST['old_image']);
				$extension = pathinfo($_FILES["image4"]["name"])['extension'];
                $new_image = $ID . "." . $extension;
                
		
				$result = $fn->validate_image($_FILES["image4"]);
				$target_path = 'upload/images/';
				
				$filename = microtime(true) . '.' . strtolower($extension);
				$full_path = $target_path . "" . $filename;
				if (!move_uploaded_file($_FILES["image4"]["tmp_name"], $full_path)) {
					echo '<p class="alert alert-danger">Can not upload image.</p>';
					return false;
					exit();
				}
				if (!empty($old_image4)) {
					unlink( $old_image4);
				}
                $upload_image4 = 'upload/images/' . $filename;
                $sql = "UPDATE packages SET image4='$upload_image4' WHERE id =  $ID";
                $db->sql($sql);
			}

			
            $sql = "UPDATE packages SET name='$name',price='$price',category_id='$category',description='$description',pincode='$pincode',status='$status',recommend= $recommend WHERE id =  $ID";
            $db->sql($sql);
            $update_result = $db->getResult();
            if (!empty($update_result)) {
                $update_result = 0;
            } else {
                $update_result = 1;
            }
           	// check update result
			if ($update_result == 1) {
				$error['update_package'] = " <section class='content-header'><span class='label label-success'>Package updated Successfully</span></section>";
			} else {
				$error['update_package'] = " <span class='label label-danger'>Failed update package</span>";
			}

        }
    }
// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM packages WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();
 ?>
<section class="content-header">
	<h1>
		Edit Package<small><a href='packages.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Packages</a></small></h1>
	<small><?php echo isset($error['update_package']) ? $error['update_package'] : ''; ?></small>
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
                    <h3 class="box-title">Edit Package</h3>
                </div>
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='edit_package_form' method="post" enctype="multipart/form-data">
                    <div class="box-body">
                    <input type="hidden" id="old_image" name="old_image"  value="<?= $res[0]['cover_photo']; ?>">
                    <input type="hidden" id="old_image1" name="old_image"  value="<?= $res[0]['image1']; ?>">
                    <input type="hidden" id="old_image2" name="old_image"  value="<?= $res[0]['image2']; ?>">
                    <input type="hidden" id="old_image3" name="old_image"  value="<?= $res[0]['image3']; ?>">
                    <input type="hidden" id="old_image4" name="old_image"  value="<?= $res[0]['image4']; ?>">

                        <div class="row">
                            <div class="form-group">
                               <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Name</label><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                    <input type="text" class="form-control" name="name" value="<?php echo $res[0]['name']; ?>">
                                </div>
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Pincode</label><?php echo isset($error['pincode']) ? $error['pincode'] : ''; ?>
                                    <input type="text" class="form-control" name="pincode" value="<?php echo $res[0]['pincode']; ?>">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="form-group">
                               <div class='col-md-4'>
                                       <label for="exampleInputFile">Cover Image</label>
                                        
                                        <input type="file" accept="image/png,  image/jpeg" onchange="readURL(this);"  name="image" id="image">
                                        <p class="help-block"><img id="blah" src="<?php echo DOMAIN_URL . $res[0]['cover_photo']; ?>" style="max-width:100%" /></p>
                                </div>
                                <div class='col-md-4'>
                                       <label for="exampleInputFile">Image1</label>
                                        
                                        <input type="file" accept="image/png,  image/jpeg" onchange="readURL(this);"  name="image1" id="image1">
                                        <p class="help-block"><img id="blah" src="<?php echo DOMAIN_URL . $res[0]['image1']; ?>" style="max-width:100%" /></p>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="form-group">
                               <div class='col-md-4'>
                                       <label for="exampleInputFile">Image2</label>
                                        
                                        <input type="file" accept="image/png,  image/jpeg" onchange="readURL(this);"  name="image2" id="image2">
                                        <p class="help-block"><img id="blah" src="<?php echo DOMAIN_URL . $res[0]['image2']; ?>" style="max-width:100%" /></p>
                                </div>
                                <div class='col-md-4'>
                                       <label for="exampleInputFile">Image3</label>
                                        
                                        <input type="file" accept="image/png,  image/jpeg" onchange="readURL(this);"  name="image3" id="image3">
                                        <p class="help-block"><img id="blah" src="<?php echo DOMAIN_URL . $res[0]['image3']; ?>" style="max-width:100%" /></p>
                                </div>
                                <div class='col-md-4'>
                                       <label for="exampleInputFile">Image4</label>
                                        
                                        <input type="file" accept="image/png,  image/jpeg" onchange="readURL(this);"  name="image4" id="image4">
                                        <p class="help-block"><img id="blah" src="<?php echo DOMAIN_URL . $res[0]['image4']; ?>" style="max-width:100%" /></p>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Price</label> <?php echo isset($error['price']) ? $error['price'] : ''; ?>
                                    <input type="text" class="form-control" name="price" value="<?php echo $res[0]['price']; ?>" >
                                </div>
                                <div class='col-md-4'>
                                    <label for="">category</label><?php echo isset($error['category']) ? $error['category'] : ''; ?>
                                    <select id='category' name="category" class='form-control' value="<?php echo $res[0]['category']; ?>">
                                            <?php
                                            $sql = "SELECT * FROM `categories` WHERE status = 1";
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
                                    <label for="exampleInputEmail1">Description</label><?php echo isset($error['description']) ? $error['description'] : ''; ?>
                                    <input type="text" class="form-control" name="description" value="<?php echo $res[0]['description']; ?>">
                                </div>
                                <div class='col-md-4'>
                                        <label class="control-label">Recommend</label>
                                        <div id="recommend" class="form-group">
                                            <label class="btn btn-default" data-toggle-class="btn-default" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="recommend" value="1" <?= ($res[0]['recommend'] == 1) ? 'checked' : ''; ?>> Yes
                                            </label>
                                            <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="recommend" value="0" <?= ($res[0]['recommend'] == 0) ? 'checked' : ''; ?>> No
                                            </label>
                                        </div>
						        </div>
                              
                               
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-4'>
                                        <label class="control-label">Status</label>
                                        <div id="status" class="btn-group">
                                            <label class="btn btn-default" data-toggle-class="btn-default" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="status" value="0" <?= ($res[0]['status'] == 0) ? 'checked' : ''; ?>> Deactivated
                                            </label>
                                            <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="status" value="1" <?= ($res[0]['status'] == 1) ? 'checked' : ''; ?>> Activated
                                            </label>
                                        </div>
						        </div>
					       </div>
                        </div>
                        <hr>
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
<?php $db->disconnect(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>