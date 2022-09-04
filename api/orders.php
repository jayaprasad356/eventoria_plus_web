<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
date_default_timezone_set('Asia/Kolkata');

include_once('../includes/crud.php');

$db = new Database();
$db->connect();

if (empty($_POST['package_id'])) {
    $response['success'] = false;
    $response['message'] = "Package Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['type'])) {
    $response['success'] = false;
    $response['message'] = "Type is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "User Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['pincode'])) {
    $response['success'] = false;
    $response['message'] = "Pincode is Empty";
    print_r(json_encode($response));
    return false;
}
$package_id = $db->escapeString($_POST['package_id']);
$type = $db->escapeString($_POST['type']);
$user_id = $db->escapeString($_POST['user_id']);
$pincode = $db->escapeString($_POST['pincode']);
$order_date = date('Y-m-d');
$price = $db->escapeString($_POST['price']);
$promo_code = $db->escapeString($_POST['promo_code']);
$sql = "SELECT * FROM packages WHERE id = '$package_id'";
$db->sql($sql);
$res = $db->getResult();
$package_name = $res[0]['name'];

if($type=='own'){
    $address_id = $db->escapeString($_POST['address_id']);
    $sql = "SELECT * FROM address WHERE id = '$address_id'";
    $db->sql($sql);
    $res = $db->getResult();
    $address = $res[0]['name'].$res[0]['address'].$res[0]['district'].$res[0]['pincode'].$res[0]['state'];

    $sql = "INSERT INTO orders (`order_date`,`package_name`,`user_id`,`promo_code`,`address`,`address_id`,`package_id`,`price`,`type`,`status`,`pincode`)VALUES('$order_date','$package_name','$user_id','$promo_code','$address','$address_id','$package_id','$price','$type',1,'$pincode')";
    $db->sql($sql);
    $res = $db->getResult();
    $response['success'] = true;
    $response['message'] = "Order Placed Successfully ";
    $response['data'] = $res;
    print_r(json_encode($response));

}
else{
    $time_slot_id = $_POST['time_slot_id'];
    $time_slot_arr = json_decode($time_slot_id, true);
    $price = $db->escapeString($_POST['price']);
    $venue_id = $db->escapeString($_POST['venue_id']);
    $event_date = $db->escapeString($_POST['event_date']);
    $sql = "SELECT * FROM venue WHERE id = '$venue_id'";
    $db->sql($sql);
    $res = $db->getResult();
    $address = $res[0]['address'];
    $sql = "INSERT INTO orders (`order_date`,`package_name`,`event_date`,`user_id`,`promo_code`,`address`,`venue_id`,`package_id`,`type`,`price`,`status`,`pincode`)VALUES('$order_date','$package_name','$event_date','$user_id','$promo_code','$address','$venue_id','$package_id','$type','$price',1,'$pincode')";
    $db->sql($sql);
    $res = $db->getResult();
    $sql = "SELECT * FROM orders ORDER BY id DESC LIMIT 1";
    $db->sql($sql);
    $res = $db->getResult();
    $order_id = $res[0]['id'];
    for ($i = 0; $i < count($time_slot_arr); $i++) {
        $sql = "SELECT * FROM timeslots WHERE id='$time_slot_arr[$i]'";
        $db->sql($sql);
        $rt = $db->getResult();
        $time_slot_id = $rt[0]['id'];
        $start_time = $rt[0]['start_time'];
        $end_time = $rt[0]['end_time'];
        $prices = $rt[0]['prices'];
        $sql = "INSERT INTO orders_timeslot (`user_id`,`order_id`,`venue_id`,`time_slot_id`,`start_time`,`end_time`,
        `price`)VALUES('$user_id','$order_id','$venue_id','$time_slot_arr[$i]','$start_time','$end_time','$prices')";
        $db->sql($sql);
    }
    $response['success'] = true;
    $response['message'] = "Order Placed Successfully ";
    $response['data'] = $res;
    print_r(json_encode($response));

}




?>