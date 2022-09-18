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
include_once('../includes/custom-functions.php');
$fn = new custom_functions;
$config = $fn->get_configurations();

$response = array();

if (isset($_POST['validate_promo_code']) && $_POST['validate_promo_code'] == 1) {

    if ((isset($_POST['user_id']) && $_POST['user_id'] != '') && (isset($_POST['promo_code']) && $_POST['promo_code'] != '') && (isset($_POST['total']) && $_POST['total'] != '') && (isset($_POST['category_id']) && $_POST['category_id'] != '')) {
        $user_id = $db->escapeString($fn->xss_clean($_POST['user_id']));
        $promo_code = $db->escapeString($fn->xss_clean($_POST['promo_code']));
        $total = $db->escapeString($fn->xss_clean($_POST['total']));
        $category_id = $db->escapeString($fn->xss_clean($_POST['category_id']));
        $response = $fn->validate_promo_code($user_id, $promo_code, $total, $category_id);
        print_r(json_encode($response));
        return false;
    } else {
        $response['error'] = true;
        $response['message'] = "Please enter user id,promo code and total.";
        echo json_encode($response);
        return false;
    }
}

if (isset($_POST['get_promo_codes']) && $_POST['get_promo_codes'] == 1) {
    $offset = (isset($_POST['offset']) && !empty(trim($_POST['offset'])) && is_numeric($_POST['offset'])) ? $db->escapeString(trim($fn->xss_clean($_POST['offset']))) : 0;
    $limit = (isset($_POST['limit']) && !empty(trim($_POST['limit'])) && is_numeric($_POST['limit'])) ? $db->escapeString(trim($fn->xss_clean($_POST['limit']))) : 10;

    $sort = (isset($_POST['sort']) && !empty(trim($_POST['sort']))) ? $db->escapeString(trim($fn->xss_clean($_POST['sort']))) : 'id';
    $order = (isset($_POST['order']) && !empty(trim($_POST['order']))) ? $db->escapeString(trim($fn->xss_clean($_POST['order']))) : 'DESC';

    $sql = "SELECT count(id) as total FROM `promo_codes` WHERE status=1 AND CURDATE() between start_date and end_date";
    $db->sql($sql);
    $total = $db->getResult();

    $sql = "SELECT * FROM promo_codes WHERE status=1 AND CURDATE() between start_date and end_date ORDER BY `$sort` $order LIMIT $offset,$limit";
    $db->sql($sql);
    $res = $db->getResult();
    if (!empty($res)) {
        $response['error'] = false;
        $response['total'] = $total[0]['total'];
        $response['data'] = $res;
    } else {
        $response['error'] = true;
        $response['message'] = 'Data not Found!';
    }
    print_r(json_encode($response));
}




?>
