<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
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
		$status = $db->escapeString($fn->xss_clean($_POST['status']));
		$error = array();

		if (empty($name)) {
			$error['name'] = " <span class='label label-danger'>Required!</span>";
		}
		if (empty($status)) {
			$error['status'] = " <span class='label label-danger'>Required!</span>";
		}

		

        if (!empty($name) && !empty($shop_name) && !empty($email) && !empty($mobile) && !empty($password) && !empty($latitude) && !empty($longitude) && !empty($pincode)) {
			if ($_FILES['image']['size'] != 0 && $_FILES['image']['error'] == 0 && !empty($_FILES['image'])) {
				//image isn't empty and update the image
				$old_image = $db->escapeString($_POST['old_image']);
				$extension = pathinfo($_FILES["image"]["name"])['extension'];
		
				$result = $fn->validate_image($_FILES["image"]);
				$target_path = 'upload/shops/';
				
				$filename = microtime(true) . '.' . strtolower($extension);
				$full_path = $target_path . "" . $filename;
				if (!move_uploaded_file($_FILES["image"]["tmp_name"], $full_path)) {
					echo '<p class="alert alert-danger">Can not upload image.</p>';
					return false;
					exit();
				}
				if (!empty($old_image)) {
					unlink($old_image);
				}
				$upload_image = $filename;
				$sql = "UPDATE shops SET `logo`='" . $upload_image . "' WHERE `id`=" . $ID;
				$db->sql($sql);
			}
			
             $sql_query = "UPDATE shops SET name='$name',shop_name='$shop_name',email='$email',mobile='$mobile',password='$password',pincode='$pincode',street='$street',state='$state',latitude='$latitude',longitude='$longitude',account_number='$account_number',bank_ifsc_code='$bank_ifsc_code',holder_name='$holder_name',bank_name='$bank_name',balance='$balance',status='$status' WHERE id =  $ID";
			 $db->sql($sql_query);
             $update_result = $db->getResult();
			if (!empty($update_result)) {
				$update_result = 0;
			} else {
				$update_result = 1;
			}

			// check update result
			if ($update_result == 1) {
				$error['update_shop'] = " <section class='content-header'><span class='label label-success'>Shop updated Successfully</span></section>";
			} else {
				$error['update_shop'] = " <span class='label label-danger'>Failed update Shop</span>";
			}
		}
	} 


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM shops WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
	<script>
		window.location.href = "shops.php";
	</script>
<?php } ?>
<section class="content-header">
	<h1>
		Edit Shop<small><a href='shops.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Shops</a></small></h1>
	<small><?php echo isset($error['update_shop']) ? $error['update_shop'] : ''; ?></small>
	<ol class="breadcrumb">
		<li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
	</ol>
</section>
<section class="content">
	<!-- Main row -->

	<div class="row">
		<div class="col-md-12">
		
			<!-- general form elements -->
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Edit Shop</h3>
				</div><!-- /.box-header -->
				<!-- form start -->
				<form id="edit_shop_form" method="post" enctype="multipart/form-data">
					<div class="box-body">
					<input type="hidden" id="old_image" name="old_image"  value="<?="upload/shops/" .$res[0]['logo']; ?>">
					<div class="row">
                            <div class="form-group">
                                <div class="col-md-5">
                                    <label for="exampleInputEmail1"> Name</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="name" value="<?php echo $res[0]['name']; ?>">
                                </div>
                                <div class="col-md-5">
                                    <label for="exampleInputEmail1"> Shop Name</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="shop_name" value="<?php echo $res[0]['shop_name']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                               <div class="col-md-4">
                                    <label for="exampleInputEmail1">Mobile Number</label> <i class="text-danger asterik">*</i>
                                    <input type="number" class="form-control" name="mobile" value="<?php echo $res[0]['mobile']; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1"> Email Id</label> <i class="text-danger asterik">*</i>
                                    <input type="email" class="form-control" name="email" value="<?php echo $res[0]['email']; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Password</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="password" value="<?php echo $res[0]['password']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                               <div class="col-md-4">
                                    <label for="exampleInputEmail1">Pincode</label> <i class="text-danger asterik">*</i>
                                    <input type="number" class="form-control" name="pincode" value="<?php echo $res[0]['pincode']; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Street</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="street" value="<?php echo $res[0]['street']; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">State</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="state" value="<?php echo $res[0]['state']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                               <div class="col-md-3">
                                    <label for="exampleInputEmail1">Account Number</label> 
                                    <input type="number" class="form-control" name="account_number" value="<?php echo $res[0]['account_number']; ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="exampleInputEmail1">IFSC Code</label>
                                    <input type="text" class="form-control" name="bank_ifsc_code" value="<?php echo $res[0]['bank_ifsc_code']; ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="exampleInputEmail1">Account Holder Name</label>
                                    <input type="text" class="form-control" name="holder_name" value="<?php echo $res[0]['holder_name']; ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="exampleInputEmail1">Bank Name</label> 
                                    <input type="text" class="form-control" name="bank_name" value="<?php echo $res[0]['bank_name']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                               <div class="col-md-4">
                                    <label for="exampleInputEmail1">Latitude</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="latitude" value="<?php echo $res[0]['latitude']; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Longitude</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="longitude" value="<?php echo $res[0]['longitude']; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Balance</label>
                                    <input type="number" class="form-control" name="balance" value="<?php echo $res[0]['balance']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
						<div class="row">
							<div class="form-group">
								<div class="col-md-4">
							        	<label class="control-label">Status</label> <i class="text-danger asterik">*</i><br>
										<div id="status" class="btn-group">
											<label class="btn btn-danger" data-toggle-class="btn-default" data-toggle-passive-class="btn-default">
												<input type="radio" name="status" value="0" <?= ($res[0]['status'] == 0) ? 'checked' : ''; ?>> Deactive
											</label>
											<label class="btn btn-success" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
												<input type="radio" name="status" value="1" <?= ($res[0]['status'] == 1) ? 'checked' : ''; ?>> Active
											</label>
										</div>
								</div>
								<div class="col-md-4">
							    	<div class="form-group">
                                        <label for="exampleInputFile">Logo</label> <i class="text-danger asterik">*</i>
                                        <input type="file" accept="image/png,  image/jpeg" onchange="readURL(this);"  name="image" id="image">
                                        <p class="help-block"><img id="blah" src="<?php echo "upload/shops/".$res[0]['logo']; ?>" style="max-width:100%;height:90px;" /></p>
                                    </div>
								</div>
							</div>
						</div>
						
					</div><!-- /.box-body -->

					<div class="box-footer">
						<button type="submit" class="btn btn-primary" name="btnEdit">Update</button>
					
					</div>
				</form>
			</div><!-- /.box -->
		</div>
	</div>
</section>

<div class="separator"> </div>
<?php $db->disconnect(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
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
