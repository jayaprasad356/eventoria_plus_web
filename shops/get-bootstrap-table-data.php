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

if (isset($_GET['table']) && $_GET['table'] == 'used_vehicles') {

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
        $where .= "WHERE bike_name like '%" . $search . "%' OR model like '%" . $search . "%' OR location like '%" . $search . "%' OR price like '%" . $search . "%'";
    }
    if (isset($_GET['sort'])) {
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])) {
        $order = $db->escapeString($_GET['order']);
    }
    $sql = "SELECT COUNT(`id`) as total FROM `used_vehicles` ";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `used_vehicles` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . "," . $limit;
    $db->sql($sql);
    $res = $db->getResult();


    $bulkData = array();
    $bulkData['total'] = $total;

    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate = ' <a href="edit-used_vehicle.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['brand'] = $row['brand'];
        $tempRow['bike_name'] = $row['bike_name'];
        $tempRow['model'] = $row['model'];
        $tempRow['km_driven'] = $row['km_driven'];
        $tempRow['price'] = $row['price'];
        $tempRow['location'] = $row['location'];
        $tempRow['color'] = $row['color'];
        if (!empty($row['image'])) {
            $tempRow['image'] = "<a data-lightbox='category' href='" . $row['image'] . "' data-caption='" . $row['image'] . "'><img src='../upload/vehicles/". $row['image'] . "' title='" . $row['image'] . "' height='50' /></a>";
        } else {
            $tempRow['image'] = 'No Image';
        }
        if ($row['status'] == 0)
           $tempRow['status'] = "<label class='label label-danger'>Not-Available</label>";
        else
           $tempRow['status'] = "<label class='label label-success'>Available</label>";
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}
if (isset($_GET['table']) && $_GET['table'] == 'rental_vehicles') {

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
        $where .= "WHERE category like '%" . $search . "%' OR brand like '%" . $search . "%' OR bike_name like '%" . $search . "%'";
    }
    if (isset($_GET['sort'])) {
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])) {
        $order = $db->escapeString($_GET['order']);
    }
    $sql = "SELECT COUNT(`id`) as total FROM `rental_vehicles` ";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `rental_vehicles` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . "," . $limit;
    $db->sql($sql);
    $res = $db->getResult();


    $bulkData = array();
    $bulkData['total'] = $total;

    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate = ' <a href="edit-rental_vehicle.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['rental_category_id'] = $row['rental_category_id'];
        $tempRow['pincode'] = $row['pincode'];
        if (!empty($row['image'])) {
            $tempRow['image'] = "<a data-lightbox='category' href='" . $row['image'] . "' data-caption='" . $row['image'] . "'><img src='../upload/rentals/" . $row['image'] . "' title='" . $row['image'] . "' height='50' /></a>";
        } else {
            $tempRow['image'] = 'No Image';
        }
        if ($row['status'] == 1)
            $tempRow['status'] = "<p class='text text-success'>Available</p>";
        else
            $tempRow['status'] = "<p class='text text-danger'>Unavailable</p>";
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}
if (isset($_GET['table']) && $_GET['table'] == 'rental_orders') {

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
        $where .= "AND ro.mobile like '%" . $search . "%' OR ro.name like '%" . $search . "%' OR ro.start_time like '%" . $search . "%' OR ro.status like '%" . $search . "%' ";
    }
    if (isset($_GET['sort'])) {
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])) {
        $order = $db->escapeString($_GET['order']);
    }

    $join = "LEFT JOIN `rental_vehicles` rv ON ro.rental_vehicles_id = rv.id WHERE ro.id IS NOT NULL ";


    $sql = "SELECT COUNT(ro.id) as total FROM `rental_orders` ro $join " . $where . "";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT ro.id AS id,ro.*,ro.status AS status FROM `rental_orders` ro $join 
            $where ORDER BY $sort $order LIMIT $offset, $limit";
    $db->sql($sql);
    $res = $db->getResult();


    $bulkData = array();
    $bulkData['total'] = $total;

    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate = '<a href="view-rental_order.php?id=' . $row['id'] . '" class="label label-primary" title="View">View</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['rental_vehicles_id'] = $row['rental_vehicles_id'];
        $tempRow['start_time'] = $row['start_time'];
        $tempRow['end_time'] = $row['end_time'];
        $tempRow['status'] = $row['status'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}
if (isset($_GET['table']) && $_GET['table'] == 'used_vehicle_orders') {

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
        $where .= "WHERE user_id like '%" . $search . "%' OR status like '%" . $search . "%' OR used_vehicles_id like '%" . $search . "%'";
    }
    if (isset($_GET['sort'])) {
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])) {
        $order = $db->escapeString($_GET['order']);
    }
    $sql = "SELECT COUNT(`id`) as total FROM `used_vehicle_orders` ";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `used_vehicle_orders` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . "," . $limit;
    $db->sql($sql);
    $res = $db->getResult();


    $bulkData = array();
    $bulkData['total'] = $total;

    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate = '<a href="view-used_vehicle_order.php?id=' . $row['id'] . '" class="label label-primary" title="View">View</a>';
        $operate .= '<a href="edit-used_vehicle_order.php?id=' . $row['id'] . '" class="fa fa-edit">Edit</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['user_id'] = $row['user_id'];
        $tempRow['used_vehicles_id'] = $row['used_vehicles_id'];
        $tempRow['price'] = $row['price'];
        $tempRow['description'] = $row['description'];
        if ($row['status'] == 0)
            $tempRow['status'] = "<p class='text text-info'>Booked</p>";
        else if ($row['status'] == 1)
            $tempRow['status'] = "<p class='text text-success'>Confirmed</p>";
        else
            $tempRow['status'] = "<p class='text text-danger'>Completed</p>";
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}
if (isset($_GET['table']) && $_GET['table'] == 'services') {

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
        $where .= "WHERE service_type like '%" . $search . "%' OR category like '%" . $search . "%'OR bike_name like '%" . $search . "%'";
    }
    if (isset($_GET['sort'])) {
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])) {
        $order = $db->escapeString($_GET['order']);
    }
    $sql = "SELECT COUNT(`id`) as total FROM `services` ";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `services` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . "," . $limit;
    $db->sql($sql);
    $res = $db->getResult();


    $bulkData = array();
    $bulkData['total'] = $total;

    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {


        $tempRow['id'] = $row['id'];
        $tempRow['bike_name'] = $row['name'];
        $tempRow['model'] = $row['model'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['service_type'] = $row['service_type'];
        $tempRow['category'] = $row['category'];
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

$db->disconnect();
