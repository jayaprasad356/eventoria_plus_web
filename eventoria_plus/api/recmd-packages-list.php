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

$sql = "SELECT * FROM packages WHERE recommend = 1 AND status = 1";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if($num>=1){
    foreach ($res as $row) {
    $temp['id'] = $row['id'];
    $temp['name'] = $row['name'];
    $temp['cover_photo'] = DOMAIN_URL . $row['cover_photo'];
    $temp['price'] = $row['price'];
    $temp['category_id'] = $row['category_id'];
    $temp['description'] = $row['description'];
    $temp['pincode'] = $row['pincode'];
    $rows[] = $temp;
    
    }

    $response['success'] = true;
    $response['message'] = "Recommended Packages listed Successfully";
    $response['data'] = $rows;
    print_r(json_encode($response));
}
else{
    $response['success'] = false;
    $response['message'] = "No Recommended Package Found";
    print_r(json_encode($response));

}



?>