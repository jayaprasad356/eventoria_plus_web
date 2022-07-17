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
if (empty($_POST['category_id'])) {
    $response['success'] = false;
    $response['message'] = "Category Id is Empty";
    print_r(json_encode($response));
    return false;
}
$pincode = $db->escapeString($_POST['pincode']);
$category_id = $db->escapeString($_POST['category_id']);

$sql = "SELECT * FROM packages WHERE pincode='$pincode' AND category_id='$category_id'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    foreach ($res as $row) {
        $temp['id'] = $row['id'];
        $temp['name'] = $row['name'];
        $temp['cover_photo'] = DOMAIN_URL . $row['cover_photo'];
        $temp['image1'] = empty($row['image1']) ? "" : DOMAIN_URL . $row['image1'];
        $temp['image2'] = empty($row['image2']) ? "" : DOMAIN_URL . $row['image2'];
        $temp['image3'] = empty($row['image3']) ? "" : DOMAIN_URL . $row['image3'];
        $temp['image4'] = empty($row['image4']) ? "" : DOMAIN_URL . $row['image4'];
        $temp['price'] = $row['price'];
        $temp['category_id'] = $row['category_id'];
        $temp['description'] = $row['description'];
        $temp['pincode'] = $row['pincode'];
        $rows[] = $temp;
        
    }

    $response['success'] = true;
    $response['message'] = "Packages listed Successfully";
    $response['data'] = $rows;
    print_r(json_encode($response));

}else{
    $response['success'] = false;
    $response['message'] = "No Package Found";
    print_r(json_encode($response));

}

?>