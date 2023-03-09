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
                for ($i = 0; $i < count($_POST['start_time']); $i++) {
                    $slot_id = $db->escapeString($fn->xss_clean($_POST['product_variant_id'][$i]));
                    $start_time = $db->escapeString($fn->xss_clean($_POST['start_time'][$i]));
                    $end_time = $db->escapeString($fn->xss_clean($_POST['end_time'][$i]));
                    $sql = "UPDATE shop_timeslots SET start_time='$start_time',end_time='$end_time' WHERE id = $slot_id";
                    $db->sql($sql);

                }
                if (
                    isset($_POST['insert_start_time']) && isset($_POST['insert_end_time'])
                ) {
                    for ($i = 0; $i < count($_POST['insert_start_time']); $i++) {
                        $start_time = $db->escapeString($fn->xss_clean($_POST['insert_start_time'][$i]));
                        $end_time = $db->escapeString($fn->xss_clean($_POST['insert_end_time'][$i]));
                        $sql = "INSERT INTO shop_timeslots (shop_id,start_time,end_time) VALUES('$ID','$start_time','$end_time')";
                        $db->sql($sql);

                    }

                }

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

$sql_query = "SELECT * FROM shop_timeslots WHERE shop_id =" . $ID;
$db->sql($sql_query);
$resslot = $db->getResult();

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
                        <br>
                        <div id="variations">
                        <?php
                        $i=0;
                        foreach ($resslot as $row) {
                            ?>
                            <div id="packate_div"  >
                                <div class="row">
                                   <input type="hidden" class="form-control" name="product_variant_id[]" id="product_variant_id" value='<?= $row['id']; ?>' />
                                    <div class="col-md-3">
                                        <div class="form-group packate_div">
                                            <label for="exampleInputEmail1">Start Time</label> <i class="text-danger asterik">*</i>
                                            <input type="time" class="form-control" name="start_time[]" value="<?php echo $row['start_time'] ?>" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group packate_div">
                                            <label for="exampleInputEmail1">End Time</label> <i class="text-danger asterik">*</i>
                                            <input type="time" class="form-control" name="end_time[]" value="<?php echo $row['end_time'] ?>" required />
                                        </div>
                                    </div>
                                    <?php if ($i == 0) { ?>
                                        <div class='col-md-1'>
                                            <label>Variation</label>
                                            <a id='add_packate_variation' title='Add variation of product' style='cursor: pointer;'><i class="fa fa-plus-square-o fa-2x"></i></a>
                                        </div>
                                    <?php } else { ?>
                                        <div class="col-md-1" style="display: grid;">
                                            <label>Remove</label>
                                            <a class="remove_variation text-danger" data-id="data_delete" title="Remove variation of product" style="cursor: pointer;"><i class="fa fa-times fa-2x"></i></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php $i++; } ?>           
						
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

<script>
    $(document).ready(function () {
        var max_fields = 7;
        var wrapper = $("#packate_div");
        var add_button = $("#add_packate_variation");

        var x = 1;
        $(add_button).click(function (e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
                $(wrapper).append('<div class="row"><div class="col-md-3"><div class="form-group"><label for="start_time">Start Time</label>' + '<input type="time" class="form-control" name="insert_start_time[]" required="" ></div></div>'+'<div class="col-md-3"><div class="form-group"><label for="end_time">End Time</label>' + '<input type="time" class="form-control" name="insert_end_time[]" required="" ></div></div>'+ '<div class="col-md-1" style="display: grid;"><label>Remove</label><a class="remove text-danger" style="cursor: pointer;"><i class="fa fa-times fa-2x"></i></a></div>'+'</div>'); //add input box
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
<script>
    $(document).on('click', '.remove_variation', function() {
        if ($(this).data('id') == 'data_delete') {
            if (confirm('Are you sure? Want to delete this row')) {
                var id = $(this).closest('div.row').find("input[id='product_variant_id']").val();
                $.ajax({
                    url: 'public/db-operation.php',
                    type: "post",
                    data: 'id=' + id + '&delete_variant=1',
                    success: function(result) {
                        if (result) {
                            location.reload();
                        } else {
                            alert("Variant not deleted!");
                        }
                    }
                });
            }
        } else {
            $(this).closest('.row').remove();
        }
    });
</script>
