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

$user_id = $db->escapeString($_POST['user_id']);
$sql = "SELECT vo.id AS id,s.shop_name,p.pincode AS pincode,c.name AS category_name,p.name AS product_name,p.measurement,p.unit,p.product_image,p.image1,p.description,vo.quantity,vo.price AS price,vo.order_date,vo.status AS status FROM `vendor_orders` vo,`products` P,`shops` s,`categories` c WHERE vo.seller_id=s.id AND p.category_id=c.id AND vo.product_id=p.id AND vo.user_id='$user_id'";
$db->sql($sql);
$res=$db->getResult();
$num=$db->numRows($res);
if($num>=1){
    foreach ($res as $row) {
        $temp['id'] = $row['id'];
        $temp['shop_name'] = $row['shop_name'];
        $temp['category_name'] = $row['category_name'];
        $temp['product_name'] = $row['product_name'];
        $temp['measurement'] = $row['measurement'];
        $temp['unit'] = $row['unit'];
        $temp['quantity'] = $row['quantity'];
        $temp['price'] = $row['price'];
        $temp['pincode'] = $row['pincode'];
        $temp['description'] = $row['description'];
        $temp['product_image'] = DOMAIN_URL . $row['product_image'];
        $temp['image1'] = DOMAIN_URL . $row['image1'];
        $temp['order_date'] = $row['order_date'];
        $rows[] = $temp;
        
    }

    $response['success'] = true;
    $response['message'] = "Orders listed Successfully";
    $response['data'] = $res;
    print_r(json_encode($response));
  
}
else{
    $response['success'] = false;
    $response['message'] = "No Orders Found";
    print_r(json_encode($response));
}

?>