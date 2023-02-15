<?php
include_once('includes/crud.php');
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
	$sql_query = "SELECT *  FROM packages WHERE id =" . $ID;
	$db->sql($sql_query);
	$res = $db->getResult();
	$target_path = "".$res[0]['cover_photo'];
	$target_path1 = "".$res[0]['image1'];
	$target_path2 = "".$res[0]['image2'];
	$target_path3 = "".$res[0]['image3'];
	$target_path4 = "".$res[0]['image4'];

	if(unlink($target_path) && unlink($target_path1) && unlink($target_path2) && unlink($target_path3) && unlink($target_path4)){	
			$sql_query = "DELETE  FROM packages WHERE id =" . $ID;
			$db->sql($sql_query);
			$res = $db->getResult();
			header("location:packages.php");
	}
?>
