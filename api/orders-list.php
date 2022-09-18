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
if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "User Id is Empty";
    print_r(json_encode($response));
    return false;
}
$type = $db->escapeString($_POST['type']);
$user_id = $db->escapeString($_POST['user_id']);

$sql = "SELECT * FROM orders WHERE user_id='$user_id'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1){

    if($type=='own'){
    
        $sql = "SELECT *,orders.id  AS id,orders.price AS price,packages.name AS package_name,orders.price AS price,orders.status AS status  FROM orders,packages,address WHERE orders.package_id = packages.id AND orders.address_id = address.id AND orders.user_id='$user_id' ORDER BY orders.id DESC";
        $db->sql($sql);
        $res = $db->getResult();
        $num = $db->numRows($res);
        if ($num >= 1){
            foreach ($res as $row) {
                $temp['id'] = $row['id'];
                $temp['package_name'] = $row['package_name'];
                $temp['price'] =$row['price'];
                $temp['type'] = $row['type'];
                $temp['address'] = $row['name'].','.$row['address'].','.$row['district'].','.$row['state'].','.$row['pincode'];
                $temp['start_time'] = NULL;
                $temp['end_time'] = NULL;
                $temp['cancel_order'] = 'false';
                $temp['status'] = $row['status'];

                $orderdate = $row['order_date'].' '.$row['order_time'];
                $currentdate = date('Y-m-d H:i:s');
                $from_time = strtotime($orderdate); 
                $to_time = strtotime($currentdate); 
                $diff_hrs = round(abs($from_time - $to_time) / 3600);
                if($diff_hrs < 24){
                    $temp['cancel_order'] = 'true';

                }
              
                $rows[] = $temp;
                
            }
        
            $response['success'] = true;
            $response['message'] = "Orders listed Successfully";
            $response['data'] = $rows;
            print_r(json_encode($response));


        }
        else{
            $response['success'] = false;
            $response['message'] = "No Orders Found";
            $response['data'] = NULL;
            print_r(json_encode($response));

        }
        
 
        }
    else{
        $sql = "SELECT *,orders.id  AS id,orders.price AS price,packages.name AS package_name,orders.status AS status FROM orders,packages,venues WHERE orders.package_id = packages.id AND orders.venue_id = venues.id AND orders.user_id='$user_id' ORDER BY orders.id DESC";
        $db->sql($sql);
        $res = $db->getResult();
        $num = $db->numRows($res);
        if ($num >= 1){
            foreach ($res as $row) {
                $temp['id'] = $row['id'];
                $temp['package_name'] = $row['package_name'];
                $temp['price'] = $row['price'];
                $temp['type'] = $row['type'];
                $temp['status'] = $row['status'];
                $temp['address'] = $row['name'].','.$row['address'].','.$row['pincode'];
                $temp['cancel_order'] = 'false';

                $orderdate = $row['order_date'].' '.$row['order_time'];
                $currentdate = date('Y-m-d H:i:s');
                $from_time = strtotime($orderdate); 
                $to_time = strtotime($currentdate); 
                $diff_hrs = round(abs($from_time - $to_time) / 3600);
                if($diff_hrs < 24){
                    $temp['cancel_order'] = 'true';

                }
                
                $rows[] = $temp;
                
            }
        
            $response['success'] = true;
            $response['message'] = "Orders listed Successfully";
            $response['data'] = $rows;
            print_r(json_encode($response));


        }
        else {
            $response['success'] = false;
            $response['message'] = "No Orders Found";
            print_r(json_encode($response));
        }
        
    
    }
}
else {
    $response['success'] = false;
    $response['message'] = "No Orders Found";
    print_r(json_encode($response));

}

?>