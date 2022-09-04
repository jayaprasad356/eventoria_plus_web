<?php
session_start();
include('../includes/crud.php');
$db = new Database();
$db->connect();
$db->sql("SET NAMES 'utf8'");
$auth_username = $db->escapeString($_SESSION["user"]);

include_once('../includes/custom-functions.php');
$fn = new custom_functions;
include_once('../includes/functions.php');
$function = new functions;

if (isset($_POST['delete_variant'])) {
    $v_id = $db->escapeString($fn->xss_clean($_POST['id']));
    $sql = "DELETE FROM timeslots WHERE id = $v_id";
    $db->sql($sql);
    $result = $db->getResult();
    if ($result) {
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['add_promo_code']) && $_POST['add_promo_code'] == 1) {
    // if (!checkadmin($auth_username)) {
    //     echo "<label class='alert alert-danger'>Access denied - You are not authorized to access this page.</label>";
    //     return false;
    // }
    // if ($permissions['promo_codes']['create'] == 0) {
    //     echo '<label class="alert alert-danger">You have no permission to create promo code</label>';
    //     return false;
    // }
    $promo_code = $db->escapeString($fn->xss_clean($_POST['promo_code']));
    $type = $db->escapeString($fn->xss_clean($_POST['type']));
    $message = $db->escapeString($fn->xss_clean($_POST['message']));
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

    $sql = "INSERT INTO promo_codes (promo_code,message,start_date,end_date,no_of_users,minimum_order_amount,discount,discount_type,max_discount_amount,repeat_usage,no_of_repeat_usage,status,type)
                        VALUES('$promo_code', '$message', '$start_date', '$end_date','$no_of_users','$minimum_order_amount','$discount','$discount_type','$max_discount_amount','$repeat_usage','$no_of_repeat_usage','$status','$type')";
    if ($db->sql($sql)) {
        echo '<label class="alert alert-success">Promo Code Added Successfully!</label>';
    } else {
        echo '<label class="alert alert-danger">Some Error Occrred! please try again.</label>';
    }
}
if (isset($_POST['update_promo_code']) && $_POST['update_promo_code'] == 1) {
    // if (!checkadmin($auth_username)) {
    //     echo "<label class='alert alert-danger'>Access denied - You are not authorized to access this page.</label>";
    //     return false;
    // }
    // if ($permissions['promo_codes']['update'] == 0) {
    //     echo '<label class="alert alert-danger">You have no permission to update promo code</label>';
    //     return false;
    // }
    $id = $db->escapeString($fn->xss_clean($_POST['promo_code_id']));
    $promo_code = $db->escapeString($fn->xss_clean($_POST['update_promo']));
    $message = $db->escapeString($fn->xss_clean($_POST['update_message']));
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

    $sql = "UPDATE promo_codes set `promo_code`='" . $promo_code . "',`message`='" . $message . "',`start_date`='" . $start_date . "',`end_date`='" . $end_date . "',`no_of_users`='" . $no_of_users . "',`minimum_order_amount`='" . $minimum_order_amount . "',`discount`='" . $discount . "',`discount_type`='" . $discount_type . "',`max_discount_amount`='" . $max_discount_amount . "',`repeat_usage`='" . $repeat_usage . "',`no_of_repeat_usage`='" . $no_of_repeat_usage . "',`status`='" . $status . "' where `id`=" . $id;

    if ($db->sql($sql)) {
        echo "<label class='alert alert-success'>Promo Code Updated Successfully.</label>";
    } else {
        echo "<label class='alert alert-danger'>Some Error Occurred! Please Try Again.</label>";
    }
}
if (isset($_GET['delete_promo_code']) && $_GET['delete_promo_code'] == 1) {
    // if ($permissions['promo_codes']['delete'] == 0) {
    //     echo 2;
    //     return false;
    // }
    $id = $db->escapeString($fn->xss_clean($_GET['id']));
    $sql = "DELETE FROM `promo_codes` WHERE id=" . $id;
    if ($db->sql($sql)) {
        echo 0;
    } else {
        echo 1;
    }
}


