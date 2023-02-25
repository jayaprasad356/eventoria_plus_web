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

if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "User Id is Empty";
    print_r(json_encode($response));
    return false;
}

if (empty($_POST['address_id'])) {
    $response['success'] = false;
    $response['message'] = "Address Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['product_id'])) {
    $response['success'] = false;
    $response['message'] = "Product Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['quantity'])) {
    $response['success'] = false;
    $response['message'] = "Quantity is Empty";
    print_r(json_encode($response));
    return false;
}

$user_id = $db->escapeString($_POST['user_id']);
$address_id = $db->escapeString($_POST['address_id']);
$product_id = $db->escapeString($_POST['product_id']);
$quantity = $db->escapeString($_POST['quantity']);
$order_date = date('Y-m-d');
$sql="SELECT * FROM products WHERE id='$product_id'";
$db->sql($sql);
$res=$db->getResult();
$price=$res[0]['price'];
$seller_id=$res[0]['seller_id'];
$num=$db->numRows($res);
if($num>=1){
    $total_price=$quantity*$price;
    $sql = "INSERT INTO `vendor_orders` (`user_id`,`address_id`,`product_id`,`seller_id`,`quantity`,`price`,`order_date`) VALUES ('$user_id','$address_id','$product_id','$seller_id','$quantity','$total_price','$order_date')";
    $db->sql($sql);
    $res = $db->getResult();
    $response['success'] = true;
    $response['message'] = "Order Placed Successfully";
    print_r(json_encode($response));
}

?>