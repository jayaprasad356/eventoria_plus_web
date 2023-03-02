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

$sql = "SELECT *,p.id AS id,s.shop_name,p.pincode AS pincode,p.name AS product_name,c.name AS category_name FROM `products` P,`shops` s,`vendor_categories` c WHERE p.seller_id=s.id AND p.category_id=c.id AND p.status = 1";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    foreach ($res as $row) {
        $temp['id'] = $row['id'];
        $temp['shop_name'] = $row['shop_name'];
        $temp['category_name'] = $row['category_name'];
        $temp['product_name'] = $row['product_name'];
        $temp['measurement'] = $row['measurement'];
        $temp['unit'] = $row['unit'];
        $temp['price'] = $row['price'];
        $temp['pincode'] = $row['pincode'];
        $temp['description'] = $row['description'];
        $temp['product_image'] = DOMAIN_URL . $row['product_image'];
        $temp['image1'] = DOMAIN_URL . $row['image1'];
        $rows[] = $temp;
        
    }

    $response['success'] = true;
    $response['message'] = "Products listed Successfully";
    $response['data'] = $rows;
    print_r(json_encode($response));

}else{
    $response['success'] = false;
    $response['message'] = "No Products Found";
    print_r(json_encode($response));

}

?>