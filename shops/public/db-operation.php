<?php
include_once('../../includes/crud.php');
$db = new Database();
$db->connect();
$db->sql("SET NAMES 'utf8'");
session_start();

include('../../includes/variables.php');
include_once('../../includes/custom-functions.php');
include_once('../../includes/functions.php');
$function = new functions;
$fn = new custom_functions;


if (isset($_POST['add_shop']) && $_POST['add_shop'] == 1) {
    $date=date('Y-m-d');
    $name = $db->escapeString($fn->xss_clean($_POST['name']));
    $email = $db->escapeString($fn->xss_clean($_POST['email']));
    $mobile = $db->escapeString($fn->xss_clean($_POST['mobile']));
    $shop_name = $db->escapeString($fn->xss_clean($_POST['shop_name']));
    $pincode = $db->escapeString($fn->xss_clean($_POST['pincode']));
    $street = $db->escapeString($fn->xss_clean($_POST['street']));
    $state = $db->escapeString($fn->xss_clean($_POST['state']));
    $password = $db->escapeString($fn->xss_clean($_POST['password']));
    $latitude = $db->escapeString($fn->xss_clean($_POST['latitude']));
    $longitude = $db->escapeString($fn->xss_clean($_POST['longitude']));
    $account_number = (isset($_POST['account_number']) && !empty($_POST['account_number'])) ? trim($db->escapeString($fn->xss_clean($_POST['account_number']))) : "";
    $bank_ifsc_code = (isset($_POST['bank_ifsc_code']) && !empty($_POST['bank_ifsc_code'])) ? trim($db->escapeString($fn->xss_clean($_POST['bank_ifsc_code']))) : "";
    $holder_name = (isset($_POST['holder_name']) && !empty($_POST['holder_name'])) ? trim($db->escapeString($fn->xss_clean($_POST['holder_name']))) : "";
    $bank_name = (isset($_POST['bank_name']) && !empty($_POST['bank_name'])) ? trim($db->escapeString($fn->xss_clean($_POST['bank_name']))) : "";
    $balance = (isset($_POST['balance']) && !empty($_POST['balance'])) ? trim($db->escapeString($fn->xss_clean($_POST['balance']))) : 0;
    $sql = 'SELECT id FROM shops WHERE mobile=' . $mobile;
    $db->sql($sql);
    $res = $db->getResult();
    $count = $db->numRows($res);
    if ($count >= 1) {
        echo '<label class="alert alert-danger">Mobile Number Already Exists!</label>';
        return false;
    }
    $target_path = '../../upload/shops/';
    if (!is_dir($target_path)) {
        mkdir($target_path, 0777, true);
    }
    if ($_FILES['logo']['error'] == 0 && $_FILES['logo']['size'] > 0) {

        $extension = pathinfo($_FILES["logo"]["name"])['extension'];
        $result = $fn->validate_image($_FILES["logo"]);
        if (!$result) {
            echo " <span class='label label-danger'>Logo image type must jpg, jpeg, gif, or png!</span>";
            return false;
            exit();
        }
        $filename = microtime(true) . '.' . strtolower($extension);
        $full_path = $target_path . "" . $filename;
        if (!move_uploaded_file($_FILES["logo"]["tmp_name"], $full_path)) {
            echo "<p class='alert alert-danger'>Invalid directory to load image!</p>";
            return false;
        }
    }
  
    $sql = "INSERT INTO `shops` (name,shop_name,email,mobile,password,pincode,street,state,latitude,longitude,account_number,bank_ifsc_code,holder_name,bank_name,logo,balance,joined_date,status)VALUES('$name','$shop_name','$email','$mobile','$password','$pincode','$street','$state','$latitude','$longitude','$account_number','$bank_ifsc_code','$holder_name','$bank_name','$filename','$balance','$date',0)";
    if ($db->sql($sql)) {
        echo '<label class="alert alert-success">Shop Added Successfully!</label>';

    }
    else{
        echo '<label class="alert alert-danger">Failed!</label>';

    }
}

if (isset($_POST['update_shop'])  && !empty($_POST['update_shop'])) {

  

    $id = $db->escapeString($fn->xss_clean($_POST['update_id']));
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
    // $status = $db->escapeString($fn->xss_clean($_POST['status']));
    $error = array();


    $sql = "SELECT * from shops where id='$id'";
    $db->sql($sql);
    $res_id = $db->getResult();
    if (!empty($res_id) && ($res_id[0]['status'] == 0)) {
        $response['error'] = true;
        $response['message'] = "Shop can not update becasue you have not-approoved or removed.";
        print_r(json_encode($response));
        return false;
        exit();
    }
    if (isset($_POST['old_password']) && $_POST['old_password'] != '') {
        $old_password = $db->escapeString($fn->xss_clean($_POST['old_password']));
        // $old_password = md5($old_password);
        $res = $fn->get_data($column = ['password'], "id=" . $id, 'shops');
        if ($res[0]['password'] != $old_password) {
            echo "<label class='alert alert-danger'>Old password does't match.</label>";
            return false;
        }
    }

    if ($_POST['password'] != '' && $_POST['old_password'] == '') {
        echo "<label class='alert alert-danger'>Please enter old password.</label>";
        return false;
    }
    $password = !empty($_POST['password']) ? $db->escapeString($fn->xss_clean($_POST['password'])) : '';
    // $password = !empty($password) ? md5($password) : '';

    if ($_FILES['logo']['size'] != 0 && $_FILES['logo']['error'] == 0 && !empty($_FILES['logo'])) {
        //image isn't empty and update the image
        $old_logo = $db->escapeString($fn->xss_clean($_POST['old_logo']));
        $extension = pathinfo($_FILES["logo"]["name"])['extension'];

        $result = $fn->validate_image($_FILES["logo"]);
        if (!$result) {
            echo " <span class='label label-danger'>Logo image type must jpg, jpeg, gif, or png!</span>";
            return false;
            exit();
        }
        $target_path = '../../upload/shops/';
        $filename = microtime(true) . '.' . strtolower($extension);
        $full_path = $target_path . "" . $filename;
        if (!move_uploaded_file($_FILES["logo"]["tmp_name"], $full_path)) {
            echo '<p class="alert alert-danger">Can not upload image.</p>';
            return false;
            exit();
        }
        if (!empty($old_logo)) {
            unlink($target_path . $old_logo);
        }
        $sql = "UPDATE shops SET `logo`='" . $filename . "' WHERE `id`=" . $id;
        $db->sql($sql);
    }

    if (!empty($password)) {
        $sql = "UPDATE shops SET name='$name',shop_name='$shop_name',email='$email',mobile='$mobile',password='$password',pincode='$pincode',street='$street',state='$state',latitude='$latitude',longitude='$longitude',account_number='$account_number',bank_ifsc_code='$bank_ifsc_code',holder_name='$holder_name',bank_name='$bank_name',balance='$balance' WHERE id=" . $id;
    } else {
        $sql = "UPDATE shops SET name='$name',shop_name='$shop_name',email='$email',mobile='$mobile',pincode='$pincode',street='$street',state='$state',latitude='$latitude',longitude='$longitude',account_number='$account_number',bank_ifsc_code='$bank_ifsc_code',holder_name='$holder_name',bank_name='$bank_name',balance='$balance' WHERE id=" . $id;
    }
    if ($db->sql($sql)) {
        echo "<label class='alert alert-success'>Information Updated Successfully.</label>";
    } else {
        echo "<label class='alert alert-danger'>Some Error Occurred! Please Try Again.</label>";
    }
}


//coupon codes
if (isset($_POST['add_coupon_code']) && $_POST['add_coupon_code'] == 1) {
    // if (!checkadmin($auth_username)) {
    //     echo "<label class='alert alert-danger'>Access denied - You are not authorized to access this page.</label>";
    //     return false;
    // }
    // if ($permissions['coupon_codes']['create'] == 0) {
    //     echo '<label class="alert alert-danger">You have no permission to create coupon code</label>';
    //     return false;
    // }
    $seller_id = $_SESSION['seller_id'];
    $coupon_code = $db->escapeString($fn->xss_clean($_POST['coupon_code']));
    $type = $db->escapeString($fn->xss_clean($_POST['type']));
    $message = $db->escapeString($fn->xss_clean($_POST['message']));
    $category = $db->escapeString($fn->xss_clean($_POST['category']));
    $start_date = $db->escapeString($fn->xss_clean($_POST['start_date']));
    $end_date = $db->escapeString($fn->xss_clean($_POST['end_date']));
    $no_of_users = $db->escapeString($fn->xss_clean($_POST['no_of_users']));
    $minimum_order_amount = $db->escapeString($fn->xss_clean($_POST['minimum_order_amount']));
    $discount = $db->escapeString($fn->xss_clean($_POST['discount']));
    $discount_type = $db->escapeString($fn->xss_clean($_POST['discount_type']));
    $max_discount_amount = $db->escapeString($fn->xss_clean($_POST['max_discount_amount']));
    $repeat_usage = $db->escapeString($fn->xss_clean($_POST['repeat_usage']));
    $no_of_repeat_usage = !empty($_POST['repeat_usage']) ? $db->escapeString($fn->xss_clean($_POST['no_of_repeat_usage'])) : 0;
    $status = $db->escapeString($fn->xss_clean($_POST['status']));

    $sql = "INSERT INTO coupon_codes (seller_id,coupon_code,message,category_id,start_date,end_date,no_of_users,minimum_order_amount,discount,discount_type,max_discount_amount,repeat_usage,no_of_repeat_usage,status,type)
                        VALUES('$seller_id','$coupon_code', '$message','$category', '$start_date', '$end_date','$no_of_users','$minimum_order_amount','$discount','$discount_type','$max_discount_amount','$repeat_usage','$no_of_repeat_usage','$status','$type')";
    if ($db->sql($sql)) {
        echo '<label class="alert alert-success">Coupon Code Added Successfully!</label>';
    } else {
        echo '<label class="alert alert-danger">Some Error Occrred! please try again.</label>';
    }
}
if (isset($_POST['update_coupon_code']) && $_POST['update_coupon_code'] == 1) {
    // if (!checkadmin($auth_username)) {
    //     echo "<label class='alert alert-danger'>Access denied - You are not authorized to access this page.</label>";
    //     return false;
    // }
    // if ($permissions['coupon_codes']['update'] == 0) {
    //     echo '<label class="alert alert-danger">You have no permission to update coupon code</label>';
    //     return false;
    // }
    $id = $db->escapeString($fn->xss_clean($_POST['coupon_code_id']));
    $coupon_code = $db->escapeString($fn->xss_clean($_POST['update_coupon']));
    $message = $db->escapeString($fn->xss_clean($_POST['update_message']));
    $category = $db->escapeString($fn->xss_clean($_POST['update_category']));
    $start_date = $db->escapeString($fn->xss_clean($_POST['update_start_date']));
    $end_date = $db->escapeString($fn->xss_clean($_POST['update_end_date']));
    $no_of_users = $db->escapeString($fn->xss_clean($_POST['update_no_of_users']));
    $minimum_order_amount = $db->escapeString($fn->xss_clean($_POST['update_minimum_order_amount']));
    $discount = $db->escapeString($fn->xss_clean($_POST['update_discount']));
    $discount_type = $db->escapeString($fn->xss_clean($_POST['update_discount_type']));
    $max_discount_amount = $db->escapeString($fn->xss_clean($_POST['update_max_discount_amount']));
    $repeat_usage = $db->escapeString($fn->xss_clean($_POST['update_repeat_usage']));
    $no_of_repeat_usage = $repeat_usage == 0 ? '0' : $db->escapeString($fn->xss_clean($_POST['update_no_of_repeat_usage']));
    $status = $db->escapeString($fn->xss_clean($_POST['status']));
    $type = $db->escapeString($fn->xss_clean($_POST['update_type']));


    $sql = "UPDATE coupon_codes set `coupon_code`='" . $coupon_code . "',`message`='" . $message . "',`category_id`='" . $category . "',`start_date`='" . $start_date . "',`end_date`='" . $end_date . "',`no_of_users`='" . $no_of_users . "',`minimum_order_amount`='" . $minimum_order_amount . "',`discount`='" . $discount . "',`discount_type`='" . $discount_type . "',`max_discount_amount`='" . $max_discount_amount . "',`repeat_usage`='" . $repeat_usage . "',`no_of_repeat_usage`='" . $no_of_repeat_usage . "',`status`='" . $status . "',`type`='" . $type . "' where `id`=" . $id;

    if ($db->sql($sql)) {
        echo "<label class='alert alert-success'>Coupon Code Updated Successfully.</label>";
    } else {
        echo "<label class='alert alert-danger'>Some Error Occurred! Please Try Again.</label>";
    }
}
if (isset($_GET['delete_coupon_code']) && $_GET['delete_coupon_code'] == 1) {
    // if ($permissions['coupon_codes']['delete'] == 0) {
    //     echo 2;
    //     return false;
    // }
    $id = $db->escapeString($fn->xss_clean($_GET['id']));
    $sql = "DELETE FROM `coupon_codes` WHERE id=" . $id;
    if ($db->sql($sql)) {
        echo 0;
    } else {
        echo 1;
    }
}