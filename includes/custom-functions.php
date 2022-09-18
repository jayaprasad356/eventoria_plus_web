<?php

include_once('crud.php');
require_once('firebase.php');
require_once('push.php');
require_once('functions.php');


$fn = new functions;
class custom_functions
{
    protected $db;
    function __construct()
    {
        $this->db = new Database();
        $this->db->connect();
    }


    function xss_clean_array($array)
    {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = $this->xss_clean($value);
            }
        } else {
            $array = $this->xss_clean($array);
        }
        return $array;
    }

    function xss_clean($data)
    {
        $data = trim($data);
        // Fix &entity\n;
        $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        do {
            // Remove really unwanted tags
            $old_data = $data;
            $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        } while ($old_data !== $data);

        // we are done...
        return $data;
    }
    public function get_configurations()
    {
        $sql = "SELECT value FROM settings WHERE `variable`='system_timezone'";
        $this->db->sql($sql);
        $res = $this->db->getResult();
        if (!empty($res)) {
            return  true;
        } else {
            return false;
        }
    }
    public function validate_image($file, $is_image = true)
    {
        if (function_exists('finfo_file')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $type = finfo_file($finfo, $file['tmp_name']);
        } else if (function_exists('mime_content_type')) {
            $type = mime_content_type($file['tmp_name']);
        } else {
            $type = $file['type'];
        }
        $type = strtolower($type);
        if ($is_image == false) {
            if (in_array($type, array('text/plain', 'application/csv', 'application/vnd.ms-excel', 'text/csv'))) {
                return true;
            } else {
                return false;
            }
        } else {
            if (in_array($type, array('image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'application/octet-stream'))) {
                return true;
            } else {
                return false;
            }
        }
    }
    public function validate_promo_code($user_id, $promo_code, $total, $category_id)
    {
        $sql = "select * from promo_codes where promo_code='" . $promo_code . "'";
        $this->db->sql($sql);
        $res = $this->db->getResult();
        if (empty($res)) {
            $response['error'] = true;
            $response['message'] = "Invalid promo code.";
            return $response;
            exit();
        }
        if ($res[0]['status'] == 0) {
            $response['error'] = true;
            $response['message'] = "This promo code is either expired / invalid.";
            return $response;
            exit();
        }

        $sql = "select id from users where id='" . $user_id . "'";
        $this->db->sql($sql);
        $res_user = $this->db->getResult();
        if (empty($res_user)) {
            $response['error'] = true;
            $response['message'] = "Invalid user data.";
            return $response;
            exit();
        }

        $start_date = $res[0]['start_date'];
        $end_date = $res[0]['end_date'];
        $date = date('Y-m-d h:i:s a');

        if ($date < $start_date) {
            $response['error'] = true;
            $response['message'] = "This promo code can't be used before " . date('d-m-Y', strtotime($start_date)) . "";
            return $response;
            exit();
        }
        if ($date > $end_date) {
            $response['error'] = true;
            $response['message'] = "This promo code can't be used after " . date('d-m-Y', strtotime($end_date)) . "";
            return $response;
            exit();
        }
        if ($total < $res[0]['minimum_order_amount']) {
            $response['error'] = true;
            $response['message'] = "This promo code is applicable only for order amount greater than or equal to " . $res[0]['minimum_order_amount'] . "";
            return $response;
            exit();
        }

        if ($res[0]['category_id'] != 0 && $res[0]['category_id'] != $category_id) {
            $response['error'] = true;
            $response['message'] = "This promo code is not applicable for this category product";
            return $response;
            exit();
        }
        //check how many users have used this promo code and no of users used this promo code crossed max users or not
        $sql = "select id from orders where promo_code='" . $promo_code . "' GROUP BY user_id";
        $this->db->sql($sql);
        $res_order = $this->db->numRows();

        if ($res_order >= $res[0]['no_of_users']) {
            $response['error'] = true;
            $response['message'] = "This promo code is applicable only for first " . $res[0]['no_of_users'] . " users.";
            return $response;
            exit();
        }
        //check how many times user have used this promo code and count crossed max limit or not
        if ($res[0]['repeat_usage'] == 1) {
            $sql = "select id from orders where user_id=" . $user_id . " and promo_code='" . $promo_code . "'";
            $this->db->sql($sql);
            $total_usage = $this->db->numRows();
            if ($total_usage >= $res[0]['no_of_repeat_usage']) {
                $response['error'] = true;
                $response['message'] = "This promo code is applicable only for " . $res[0]['no_of_repeat_usage'] . " times.";
                return $response;
                exit();
            }
        }
        //check if repeat usage is not allowed and user have already used this promo code 
        if ($res[0]['repeat_usage'] == 0) {
            $sql = "select id from orders where user_id=" . $user_id . " and promo_code='" . $promo_code . "'";
            $this->db->sql($sql);
            $total_usage = $this->db->numRows();
            if ($total_usage >= 1) {
                $response['error'] = true;
                $response['message'] = "This promo code is applicable only for 1 time.";
                return $response;
                exit();
            }
        }
        if ($res[0]['discount_type'] == 'percentage') {
            $percentage = $res[0]['discount'];
            $discount = $total / 100 * $percentage;
            if ($discount > $res[0]['max_discount_amount']) {
                $discount = $res[0]['max_discount_amount'];
            }
        } else {
            $discount = $res[0]['discount'];
        }
        $discounted_amount = $total - $discount;
        $response['error'] = false;
        $response['message'] = "promo code applied successfully.";
        $response['promo_code'] = $promo_code;
        $response['promo_code_message'] = $res[0]['message'];
        $response['total'] = $total;
        $response['discount'] = "$discount";
        $response['discounted_amount'] = "$discounted_amount";
        return $response;
        exit();
    }

    public function get_settings($variable, $is_json = false)
    {
        if ($variable == 'logo' || $variable == 'Logo') {
            $sql = "select value from `settings` where variable='Logo' OR variable='logo'";
        } else {
            $sql = "SELECT value FROM `settings` WHERE `variable`='$variable'";
        }

        $this->db->sql($sql);
        $res = $this->db->getResult();
        if (!empty($res) && isset($res[0]['value'])) {
            if ($is_json)
                return json_decode($res[0]['value'], true);
            else
                return $res[0]['value'];
        } else {
            return false;
        }
    }
    public function send_notification_to_user($notify_user_id, $notify_post_id, $type, $category)
    {
        if($type == 'post'){
            $sql = "SELECT * FROM users WHERE id = '" . $notify_user_id . "'";
            $this->db->sql($sql);
            $res = $this->db->getResult();
            $sql = "SELECT * FROM posts WHERE id = '" . $notify_post_id . "'";
            $this->db->sql($sql);
            $postres = $this->db->getResult();
            $user_id = $postres[0]['user_id'];
            $user_name = $res[0]['name'];
            $title = $user_name .' '. $category . ' Your Post';
            $sql = "INSERT INTO notifications (`user_id`,`notify_user_id`,`notify_post_id`,`title`,`type`) VALUES ('$user_id','$notify_user_id','$notify_post_id','$title','$type')";
            $this->db->sql($sql);

        }
        else{
            $sql = "SELECT * FROM users WHERE id = '" . $notify_user_id . "'";
            $this->db->sql($sql);
            $res = $this->db->getResult();
            $user_name = $res[0]['name'];
            $title = $user_name .' Started Following You';
            $sql = "INSERT INTO notifications (`user_id`,`notify_user_id`,`title`,`type`) VALUES ('$notify_post_id','$notify_user_id','$title','$type')";
            $this->db->sql($sql);

        }

    }

}
// $this->db->disconnect();
