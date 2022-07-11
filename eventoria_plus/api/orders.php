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
if (empty($_POST['price'])) {
    $response['success'] = false;
    $response['message'] = "Price is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['type'])) {
    $response['success'] = false;
    $response['message'] = "Type is Empty";
    print_r(json_encode($response));
    return false;
}
$package_id = $db->escapeString($_POST['package_id']);
$price = $db->escapeString($_POST['price']);
$type = $db->escapeString($_POST['type']);
if($type=='own'){
    $address_id = $db->escapeString($_POST['address_id']);
    $sql = "INSERT INTO orders (`address_id`,`package_id`,`price`,`type`,`status`)VALUES('$address_id','$package_id','$price','$type',1)";
    $db->sql($sql);
    $res = $db->getResult();
    $response['success'] = true;
    $response['message'] = "Order Placed Successfully ";
    $response['data'] = $res;
    print_r(json_encode($response));

}
else{
    $venue_id = $db->escapeString($_POST['venue_id']);
    $sql = "INSERT INTO orders (`venue_id`,`package_id`,`price`,`type`,`status`)VALUES('$venue_id','$package_id','$price','$type',1)";
    $db->sql($sql);
    $res = $db->getResult();
    $response['success'] = true;
    $response['message'] = "Order Placed Successfully ";
    $response['data'] = $res;
    print_r(json_encode($response));

}




?>