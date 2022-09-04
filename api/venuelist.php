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
    $response['message'] = "Category ID is Empty";
    print_r(json_encode($response));
    return false;
}
$pincode = $db->escapeString($_POST['pincode']);
$category_id = $db->escapeString($_POST['category_id']);
$sql = "SELECT * FROM  venues WHERE pincode='$pincode' AND categories IN ($category_id)";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    $data = array();
    foreach ($res as $row) {
        $temp['id'] = $row['id'];
        $temp['name'] = $row['name'];
        $temp['address'] = $row['address'];
        $temp['cover_image'] = DOMAIN_URL . $row['cover_image'];
        $temp['image1'] = empty($row['image1']) ? "" : DOMAIN_URL . $row['image1'];
        $temp['image2'] = empty($row['image2']) ? "" : DOMAIN_URL . $row['image2'];
        $temp['image3'] = empty($row['image3']) ? "" : DOMAIN_URL . $row['image3'];
        $temp['image4'] = empty($row['image4']) ? "" : DOMAIN_URL . $row['image4'];
        $temp['pincode'] = $row['pincode'];
        $temp['timeslots'] = array();

        $sql="SELECT * FROM timeslots WHERE venue_id='$row[id]'";
        $db->sql($sql);
        $res = $db->getResult();
        $temp['timeslots'] = $res;
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