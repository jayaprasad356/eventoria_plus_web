<?php
session_start();

// set time for session timeout
$currentTime = time() + 25200;
$expired = 3600;
if (!isset($_SESSION['seller_id']) && !isset($_SESSION['seller_name'])) {
    header("location:index.php");
} else {
    $id = $_SESSION['seller_id'];
}

// if current time is more than session timeout back to login page
if ($currentTime > $_SESSION['timeout']) {
    session_destroy();
    header("location:index.php");
}

// destroy previous session timeout and create new one
unset($_SESSION['timeout']);
$_SESSION['timeout'] = $currentTime + $expired;

header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");



include_once('../includes/crud.php');

$db = new Database();
$db->connect();
include_once('../includes/custom-functions.php');
$fn = new custom_functions;
if (isset($_GET['table']) && $_GET['table'] == 'categories') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= "WHERE  name like '%" . $search . "%'";
    }
    if (isset($_GET['sort'])){
        $sort = $db->escapeString($_GET['sort']);

    }
    if (isset($_GET['order'])){
        $order = $db->escapeString($_GET['order']);

    }
    
    $sql = "SELECT COUNT(`id`) as total FROM `categories` ";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `categories`". $where ." ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . "," . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    
    $bulkData = array();
    $bulkData['total'] = $total;
    
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate = ' <a href="edit-category.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';

        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        if(!empty($row['image'])){
            $tempRow['image'] = "<a data-lightbox='category' href='" . $row['image'] . "' data-caption='" . $row['name'] . "'><img src='../" . $row['image'] . "' title='" . $row['name'] . "' height='50' /></a>";

        }else{
            $tempRow['image'] = 'No Image';

        }
        $tempRow['status'] = $row['status'];
       $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}
if (isset($_GET['table']) && $_GET['table'] == 'products') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= "AND p.name like '%" . $search . "%' OR c.name like '%" . $search . "%' OR p.price like '%" . $search . "%' OR p.pincode like '%" . $search . "%' ";
    }
    if (isset($_GET['sort'])) {
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])) {
        $order = $db->escapeString($_GET['order']);
    }

    $join = "LEFT JOIN `categories` c ON p.category_id = c.id WHERE p.id IS NOT NULL AND p.seller_id = $id ";


    $sql = "SELECT COUNT(p.id) as total FROM `products` p $join " . $where . "";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT p.id AS id,p.*,p.status AS status,c.name AS category FROM `products` p $join 
            $where ORDER BY $sort $order LIMIT $offset, $limit";
    $db->sql($sql);
    $res = $db->getResult();


    $bulkData = array();
    $bulkData['total'] = $total;

    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate = ' <a href="edit-product.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= ' <a class="text text-danger" href="delete-product.php?id=' . $row['id'] . '"><i class="fa fa-trash"></i>Delete</a>';        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['category'] = $row['category'];
        $tempRow['measurement'] = $row['measurement'];
        $tempRow['unit'] = $row['unit'];
        $tempRow['price'] = $row['price'];
        $tempRow['pincode'] = $row['pincode'];
        if(!empty($row['product_image'])){
            $tempRow['product_image'] = "<a data-lightbox='category' href='" . $row['product_image'] . "' data-caption='" . $row['name'] . "'><img src='../" . $row['product_image'] . "' title='" . $row['name'] . "' height='50' /></a>";

        }else{
            $tempRow['product_image'] = 'No Image';

        }
        if ($row['status'] == 0)
              $tempRow['status'] = "<p class='text text-danger'>Unavailable</p>";
        else if ($row['status'] == 1)
              $tempRow['status'] = "<p class='text text-success'>Available</p>";   
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

//orders-table goes here
if (isset($_GET['table']) && $_GET['table'] == 'vendor_orders') {
    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';
    if (isset($_GET['status']) && !empty($_GET['status'] != '')){
        $status = $db->escapeString($fn->xss_clean($_GET['status']));
        $where .= "AND o.status = '$status' ";  
    }
    if (isset($_GET['date']) && !empty($_GET['date'] != '')){
        $date = $db->escapeString($fn->xss_clean($_GET['date']));
        $where .= "AND o.order_date = '$date' ";  
    }
    if (isset($_GET['year']) && !empty($_GET['year'] != '')){
        $year = $db->escapeString($fn->xss_clean($_GET['year']));
        $where .= "AND YEAR(o.order_date) = '$year' ";  
    }
    if (isset($_GET['month']) && !empty($_GET['month'] != '')){
        $month = $db->escapeString($fn->xss_clean($_GET['month']));
        $where .= "AND MONTH(o.order_date) = '$month' ";  
    }
    if ((isset($_GET['from_date']) && !empty($_GET['from_date'] != '')) && (isset($_GET['to_date']) && !empty($_GET['to_date'] != ''))){
        $from_date = $db->escapeString($fn->xss_clean($_GET['from_date']));
        $to_date = $db->escapeString($fn->xss_clean($_GET['to_date']));
        $where .= "AND DATE(o.order_date) BETWEEN '$from_date' AND '$to_date'  ";  
    }
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= "AND u.name like '%" . $search . "%' OR p.name like '%" . $search . "%' OR o.id like '%" . $search . "%' OR u.mobile like '%" . $search . "%' OR o.quantity like '%" . $search . "%' OR o.price like '%" . $search . "%' OR o.order_date like '%" . $search . "%' ";
    }
    if (isset($_GET['sort'])) {
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])) {
        $order = $db->escapeString($_GET['order']);
    }
    $join = "LEFT JOIN `users` u ON o.user_id = u.id LEFT JOIN `products` p ON o.product_id = p.id WHERE o.id IS NOT NULL  AND o.seller_id='$id' ";

    $sql = "SELECT COUNT(o.id) as total FROM `vendor_orders` o $join " . $where . "";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
    $sql = "SELECT o.id AS id,o.*,u.name,u.mobile AS mobile,p.name AS product_name,p.description,p.price AS mrp,o.price AS total_price,o.quantity,p.product_image AS image,o.status AS status,o.order_date FROM `vendor_orders` o $join 
        $where ORDER BY $sort $order LIMIT $offset, $limit";
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();
    foreach ($res as $row) {
        
        $operate = '<a href="view-order.php?id=' . $row['id'] . '" class="label label-primary" title="View">View</a>';
        // $view = ' <a class="text text-danger" href="delete-vendor_order.php?id=' . $row['id'] . '"><i class="fa fa-trash-o"></i>Delete</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['product_name'] = $row['product_name'];
        $tempRow['description'] = $row['description'];
        $tempRow['mrp'] = $row['mrp'];
        $tempRow['quantity'] = $row['quantity'];
        $tempRow['total_price'] = $row['total_price'];
        $tempRow['order_date'] = $row['order_date'];
        if(!empty($row['image'])){
            $tempRow['image'] = "<a data-lightbox='category' href='" . $row['image'] . "' data-caption='" . $row['name'] . "'><img src='../" . $row['image'] . "' title='" . $row['name'] . "' height='50' /></a>";

        }else{
            $tempRow['image'] = 'No Image';

        }
        if ($row['status'] == 0)
            $tempRow['status'] = "<p class='text text-info'>Booked</p>";
        elseif($row['status'] == 1)
            $tempRow['status'] = "<p class='text text-success'>Confirmed</p>";
        elseif($row['status'] == 2)
            $tempRow['status'] = "<p class='text text-primary'>Completed</p>";
        else
             $tempRow['status'] = "<p class='text text-danger'>Cancelled</p>";
         $tempRow['operate'] = $operate;
        //  $tempRow['view'] = $view;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

$db->disconnect();
