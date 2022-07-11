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
if (empty($_POST['pincode'])) {
    $response['success'] = false;
    $response['message'] = "Pin Code is Empty";
    print_r(json_encode($response));
    return false;
}
$pincode = $db->escapeString($_POST['pincode']);

$sql = "SELECT * FROM venues WHERE pincode='$pincode'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    foreach ($res as $row) {
        $temp['id'] = $row['id'];
        $temp['name'] = $row['name'];
        $temp['address'] = $row['address'];
        $temp['cover_image'] = DOMAIN_URL . $row['cover_image'];
        $temp['price'] = $row['price'];
        $temp['pincode'] = $row['pincode'];
        $rows[] = $temp;
        
    }

    $response['success'] = true;
    $response['message'] = "Venues listed Successfully";
    $response['data'] = $rows;
    print_r(json_encode($response));

}else{
    $response['success'] = false;
    $response['message'] = "No Venues Found";
    print_r(json_encode($response));

}

?>