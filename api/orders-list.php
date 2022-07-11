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
if (empty($_POST['type'])) {
    $response['success'] = false;
    $response['message'] = "Type is Empty";
    print_r(json_encode($response));
    return false;
}
$type = $db->escapeString($_POST['type']);
$sql = "SELECT * FROM orders";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1){
    if($type=='own'){
    
        $sql = "SELECT *,packages.name AS package_name  FROM orders,packages,address WHERE orders.package_id = packages.id AND orders.address_id = address.id ";
        $db->sql($sql);
        $res = $db->getResult();
        $num = $db->numRows($res);
        
            foreach ($res as $row) {
                $temp['id'] = $row['id'];
                $temp['package_name'] = $row['package_name'];
                $temp['price'] =$row['price'];
                $temp['type'] = $row['type'];
                $temp['name'] = $row['name'];
                $temp['address'] = $row['address'];
                $temp['district'] = $row['district'];
                $temp['pincode'] = $row['pincode'];
                $temp['state'] = $row['state'];
              
                $rows[] = $temp;
                
            }
        
            $response['success'] = true;
            $response['message'] = "Orders listed Successfully";
            $response['data'] = $rows;
            print_r(json_encode($response));
        }
    else{
        $sql = "SELECT *,packages.name AS package_name,orders.price AS price FROM orders,packages,venues WHERE orders.package_id = packages.id AND orders.venue_id = venues.id ";
        $db->sql($sql);
        $res = $db->getResult();
        $num = $db->numRows($res);
        
            foreach ($res as $row) {
                $temp['id'] = $row['id'];
                $temp['package_name'] = $row['package_name'];
                $temp['price'] =$row['price'];
                $temp['type'] = $row['type'];
                $temp['name'] = $row['name'];
                $temp['address'] = $row['address'];
                $temp['cover_image'] =DOMAIN_URL . $row['cover_image'];
                $temp['pincode'] = $row['pincode'];
                $rows[] = $temp;
                
            }
        
            $response['success'] = true;
            $response['message'] = "Orders listed Successfully";
            $response['data'] = $rows;
            print_r(json_encode($response));

    }


}
else{
    $response['success'] = false;
    $response['message'] = "No Orders Found";
    print_r(json_encode($response));

}

?>