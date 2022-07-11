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

if (empty($_POST['name'])) {
    $response['success'] = false;
    $response['message'] = "Name is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['address'])) {
    $response['success'] = false;
    $response['message'] = "Address is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['district'])) {
    $response['success'] = false;
    $response['message'] = "District is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['pincode'])) {
    $response['success'] = false;
    $response['message'] = "Pincode is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['state'])) {
    $response['success'] = false;
    $response['message'] = "State is Empty";
    print_r(json_encode($response));
    return false;
}
$name = $db->escapeString($_POST['name']);
$address = $db->escapeString($_POST['address']);
$district = $db->escapeString($_POST['district']);
$pincode = $db->escapeString($_POST['pincode']);
$state = $db->escapeString($_POST['state']);


$sql = "INSERT INTO address (`name`,`address`,`district`,`pincode`,`state`)VALUES('$name','$address','$district','$pincode','$state')";
$db->sql($sql);
$res = $db->getResult();
$response['success'] = true;
$response['message'] = "Address Added Successfully ";
$response['data'] = $res;

print_r(json_encode($response));
?>