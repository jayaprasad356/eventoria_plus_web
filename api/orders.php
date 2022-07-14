<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


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
$package_id = $db->escapeString($_POST['package_id']);
$type = $db->escapeString($_POST['type']);
$user_id = $db->escapeString($_POST['user_id']);

if($type=='own'){
    $address_id = $db->escapeString($_POST['address_id']);

    $sql = "INSERT INTO orders (`user_id`,`address_id`,`package_id`,`price`,`type`,`status`)VALUES('$user_id','$address_id','$package_id','$price','$type',1)";
    $db->sql($sql);
    $res = $db->getResult();
    $response['success'] = true;
    $response['message'] = "Order Placed Successfully ";
    $response['data'] = $res;
    print_r(json_encode($response));

}
else{
    $time_slot_id = $_POST['time_slot_id'];
    $sql="SELECT * FROM timeslots WHERE id='$time_slot_id'";
    $db->sql($sql);
    $res = $db->getResult();
    $num = $db->numRows($res);
    $start_time = $res[0]['start_time'];
    $end_time = $res[0]['end_time'];
    $prices = $res[0]['prices'];
    $venue_id = $db->escapeString($_POST['venue_id']);
    $sql = "INSERT INTO orders (`user_id`,`venue_id`,`package_id`,`type`,`start_time`,`end_time`,`prices`,`status`)VALUES('$user_id','$venue_id','$package_id','$type','$start_time','$end_time','$prices',1)";
    $db->sql($sql);
    $res = $db->getResult();
    $response['success'] = true;
    $response['message'] = "Order Placed Successfully ";
    $response['data'] = $res;
    print_r(json_encode($response));

}




?>