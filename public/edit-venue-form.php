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
        $pincode = $db->escapeString($fn->xss_clean($_POST['pincode']));
        $description = $db->escapeString($fn->xss_clean($_POST['description']));
        $cat_id = $fn->xss_clean_array($_POST['cat_ids']);
        $cat_ids = implode(",", $cat_id);
        $error = array();

       
        if (empty($name)) {
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($address)) {
            $error['address'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($pincode)) {
            $error['pincode'] = " <span class='label label-danger'>Required!</span>";
        }

        if (!empty($name)&& !empty($address) && !empty($pincode))
        {

    //cover_photo
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
                $upload_image = 'upload/images/' . $filename;
                $sql = "UPDATE venues SET `cover_image`='" . $upload_image . "' WHERE `id`=" . $ID;
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
                $sql = "UPDATE venues SET image1='$upload_image1' WHERE id =  $ID";
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
                $sql = "UPDATE venues SET image2='$upload_image2' WHERE id =  $ID";
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
                $sql = "UPDATE venues SET image3='$upload_image3' WHERE id =  $ID";
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
                $sql = "UPDATE venues SET image4='$upload_image4' WHERE id =  $ID";
                $db->sql($sql);
            }
			
            $sql = "UPDATE venues SET name='$name',address='$address',pincode='$pincode',categories = '$cat_ids',description='$description' WHERE id =  $ID";
            $db->sql($sql);
            $res = $db->getResult();
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
                        $prices = $db->escapeString($fn->xss_clean($_POST['prices'][$i]));
                        $sql = "UPDATE timeslots SET start_time='$start_time',end_time='$end_time',prices='$prices' WHERE id = $slot_id";
                        $db->sql($sql);

                    }
                    if (
                        isset($_POST['insert_start_time']) && isset($_POST['insert_end_time'])
                        && isset($_POST['insert_prices'])
                    ) {
                        for ($i = 0; $i < count($_POST['insert_start_time']); $i++) {
                            $start_time = $db->escapeString($fn->xss_clean($_POST['insert_start_time'][$i]));
                            $end_time = $db->escapeString($fn->xss_clean($_POST['insert_end_time'][$i]));
                            $prices = $db->escapeString($fn->xss_clean($_POST['insert_prices'][$i]));
                            $sql = "INSERT INTO timeslots (venue_id,start_time,end_time,prices) VALUES('$ID','$start_time','$end_time','$prices')";
                            $db->sql($sql);
    
                        }

                    }

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

$sql_query = "SELECT * FROM timeslots WHERE venue_id =" . $ID;
$db->sql($sql_query);
$resslot = $db->getResult();

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
                            </div>
                            <div class="form-group">
                               <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Address</label><?php echo isset($error['address']) ? $error['address'] : ''; ?>
                                    <input type="text" class="form-control" name="address" value="<?php echo $res[0]['address']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Pincode</label><?php echo isset($error['pincode']) ? $error['pincode'] : ''; ?>
                                    <input type="text" class="form-control" name="pincode" value="<?php echo $res[0]['pincode']; ?>">
                                </div>
                               
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class="form-group">
                                    <label for='catogories_ids'>Category</label><i class="text-danger asterik">*</i>
                                    <select name='cat_ids[]' id='cat_ids' class='form-control' placeholder='Enter the category IDs you want to assign Seller' required multiple="multiple">
                                        <?php $sql = 'select id,name from `categories`  order by id desc';
                                        $db->sql($sql);

                                        $result = $db->getResult();
                                        foreach ($result as $value) {
                                        ?>
                                             <option value='<?= $value['id'] ?>' <?= (strpos(" " . $res[0]['categories'], $value['id'])) ? 'selected' : ''; ?>><?= $value['name'] ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                               <div class='col-md-4'>
                                       <label for="exampleInputFile">Cover Image</label>
                                        
                                        <input type="file" accept="image/png,  image/jpeg" onchange="readURL(this);"  name="image" id="image">
                                        <p class="help-block"><img id="blah" src="<?php echo DOMAIN_URL . $res[0]['cover_image']; ?>" style="max-width:100%" /></p>
                                </div>
                            </div>

                        </div>
                        <hr>
                            <div class="form-group">
                                <label for="description">Description :</label> <i class="text-danger asterik">*</i><?php echo isset($error['description']) ? $error['description'] : ''; ?>
                                <textarea name="description" id="description" class="form-control" rows="8"><?php echo $res[0]['description']; ?></textarea>
                                <script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
                                <script type="text/javascript">
                                    CKEDITOR.replace('description');
                                </script>
                            </div>
                            <hr>
                        <div class="row">
                            <div class="form-group">
                               <div class='col-md-3'>
                                       <label for="exampleInputFile">Image1</label>
                                        
                                        <input type="file" accept="image/png,  image/jpeg" onchange="readURL(this);"  name="image1" id="image1">
                                        <p class="help-block"><img id="blah" src="<?php echo DOMAIN_URL . $res[0]['image1']; ?>" style="max-width:50%;padding:4px;" /></p>
                                </div>
                               <div class='col-md-3'>
                                       <label for="exampleInputFile">Image2</label>
                                        
                                        <input type="file" accept="image/png,  image/jpeg" onchange="readURL(this);"  name="image2" id="image2">
                                        <p class="help-block"><img id="blah" src="<?php echo DOMAIN_URL . $res[0]['image2']; ?>" style="max-width:50%;padding:4px;" /></p>
                                </div>
                                <div class='col-md-3'>
                                       <label for="exampleInputFile">Image3</label>
                                        
                                        <input type="file" accept="image/png,  image/jpeg" onchange="readURL(this);"  name="image3" id="image3">
                                        <p class="help-block"><img id="blah" src="<?php echo DOMAIN_URL . $res[0]['image3']; ?>" style="max-width:50%;padding:4px;"/></p>
                                </div>
                                <div class='col-md-3'>
                                       <label for="exampleInputFile">Image4</label>
                                        
                                        <input type="file" accept="image/png,  image/jpeg" onchange="readURL(this);"  name="image4" id="image4">
                                        <p class="help-block"><img id="blah" src="<?php echo DOMAIN_URL . $res[0]['image4']; ?>" style="max-width:50%;padding:4px;" /></p>
                                </div>
                            </div>

                        </div>
                        <hr>
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
                                    <div class="col-md-3">
                                        <div class="form-group packate_div">
                                            <label for="exampleInputEmail1">Price</label> <i class="text-danger asterik">*</i>
                                            <input type="text" class="form-control" name="prices[]" value="<?php echo $row['prices'] ?>" id="packate_price" required />
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
                            <?php $i++; } ?>                        
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
<script>
    $('#cat_ids').select2({
        width: 'element',
        placeholder: 'type in category name to search',

    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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
                $(wrapper).append('<div class="row"><div class="col-md-3"><div class="form-group"><label for="start_time">Start Time</label>' + '<input type="time" class="form-control" name="insert_start_time[]" required="" ></div></div>'+'<div class="col-md-3"><div class="form-group"><label for="end_time">End Time</label>' + '<input type="time" class="form-control" name="insert_end_time[]" required="" ></div></div>'+'<div class="col-md-3"><div class="form-group"><label for="price">Price</label>' + '<input type="text" class="form-control" name="insert_prices[]" required="" ></div></div>' + '<div class="col-md-1" style="display: grid;"><label>Remove</label><a class="remove text-danger" style="cursor: pointer;"><i class="fa fa-times fa-2x"></i></a></div>'+'</div>'); //add input box
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
