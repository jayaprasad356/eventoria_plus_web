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
        $address = $db->escapeString($fn->xss_clean($_POST['address']));
        $price = $db->escapeString($fn->xss_clean($_POST['price']));
        $pincode = $db->escapeString($fn->xss_clean($_POST['pincode']));
        $error = array();

       
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
            if ($_FILES['image']['size'] != 0 && $_FILES['image']['error'] == 0 && !empty($_FILES['image']))
            {
				//image isn't empty and update the image
				$old_image = $db->escapeString($_POST['old_image']);
				$extension = pathinfo($_FILES["image"]["name"])['extension'];
		
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
			}
			$upload_image = 'upload/images/' . $filename;
            $sql = "UPDATE venues SET name='$name',address='$address',cover_image='$upload_image',price='$price',pincode='$pincode' WHERE id =  $ID";
            $db->sql($sql);
            $update_result = $db->getResult();
            if (!empty($update_result)) {
                $update_result = 0;
            } else {
                $update_result = 1;
            }
           	// check update result
			if ($update_result == 1) {
				$error['update_venue'] = " <section class='content-header'><span class='label label-success'>Venue updated Successfully</span></section>";
			} else {
				$error['update_venue'] = " <span class='label label-danger'>Failed update Venue</span>";
			}

        }
    }
// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM venues WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
	<script>
		window.location.href = "packages.php";
	</script>
<?php } ?>
<section class="content-header">
	<h1>
		Edit Venue<small><a href='venues.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Venues</a></small></h1>
	<small><?php echo isset($error['update_venue']) ? $error['update_venue'] : ''; ?></small>
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
                    <h3 class="box-title">Edit Venues</h3>
                </div>
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='edit_venue_form' method="post" enctype="multipart/form-data">
                    <div class="box-body">
                    <input type="hidden" id="old_image" name="old_image"  value="<?= $res[0]['cover_image']; ?>">
                        <div class="row">
                            <div class="form-group">
                               <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Name</label><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                    <input type="text" class="form-control" name="name" value="<?php echo $res[0]['name']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                               <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Address</label><?php echo isset($error['address']) ? $error['address'] : ''; ?>
                                    <input type="text" class="form-control" name="address" value="<?php echo $res[0]['address']; ?>">
                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="form-group">
                               <div class='col-md-4'>
                                       <label for="exampleInputFile">Cover Image</label>
                                        
                                        <input type="file" accept="image/png,  image/jpeg" onchange="readURL(this);"  name="image" id="image">
                                        <p class="help-block"><img id="blah" src="<?php echo DOMAIN_URL . $res[0]['cover_image']; ?>" style="max-width:100%" /></p>
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
                                    <label for="exampleInputEmail1">Pincode</label><?php echo isset($error['pincode']) ? $error['pincode'] : ''; ?>
                                    <input type="text" class="form-control" name="pincode" value="<?php echo $res[0]['pincode']; ?>">
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
<script>
	$('#edit_venue_form').validate({
		rules: {
			

		}
	});
</script>