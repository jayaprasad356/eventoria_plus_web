<?php
include_once('../includes/crud.php');
$db = new Database();
$db->connect();
	
	if (isset($_GET['id'])) {
		$ID = $db->escapeString($_GET['id']);
	} else {
		// $ID = "";
		return false;
		exit(0);
	}
	$data = array();
	$sql_query = "SELECT *  FROM products WHERE id =" . $ID;
	$db->sql($sql_query);
	$res = $db->getResult();
	$target_path = "../".$res[0]['product_image'];
	$target_path1 = "../".$res[0]['image1'];


	if(unlink($target_path) && unlink($target_path1)){	
			$sql_query = "DELETE  FROM products WHERE id =" . $ID;
			$db->sql($sql_query);
			$res = $db->getResult();
			header("location:products.php");
	}
?>
