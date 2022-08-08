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

$sql = "SELECT * FROM promo_codes";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    foreach ($res as $row) {
        $temp['id'] = $row['id'];
        $temp['promo_code'] = $row['promo_code'];
        $temp['message'] = $row['message'];
        $temp['start_date'] = $row['start_date'];
        $temp['end_date'] = $row['end_date'];
        $temp['no_of_users'] = $row['no_of_users'];
        $temp['minimum_order_amount'] = $row['minimum_order_amount'];
        $temp['discount'] = $row['discount'];
        $temp['discount_type'] = $row['discount_type'];
        $temp['max_discount_amount'] = $row['max_discount_amount'];
        $temp['repeat_usage'] = $row['repeat_usage'];
        $temp['no_of_repeat_usage'] = $row['no_of_repeat_usage'];
        $temp['date_created'] = $row['date_created'];
        $temp['status'] = $row['status'];
        $rows[] = $temp;
        
    }

    $response['success'] = true;
    $response['message'] = "Promo Codes listed Successfully";
    $response['data'] = $rows;
    print_r(json_encode($response));

}else{
    $response['success'] = false;
    $response['message'] = "No Promcodes Found";
    print_r(json_encode($response));

}

?>