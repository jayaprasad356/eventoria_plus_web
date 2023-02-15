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
  
    $sql = "INSERT INTO `shops` (name,shop_name,email,mobile,password,pincode,street,state,latitude,longitude,account_number,bank_ifsc_code,holder_name,bank_name,logo,balance,status)VALUES('$name','$shop_name','$email','$mobile','$password','$pincode','$street','$state','$latitude','$longitude','$account_number','$bank_ifsc_code','$holder_name','$bank_name','$filename','$balance',0)";
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
