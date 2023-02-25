
<?php session_start();

include_once('../includes/custom-functions.php');

$function = new custom_functions;

// set time for session timeout
$currentTime = time() + 25200;
$expired = 900;

if (!isset($_SESSION['seller_id']) && !isset($_SESSION['seller_name'])) {
    header("location:index.php");
} else {
    $ID = $_SESSION['seller_id'];
}

// if current time is more than session timeout back to login page
if ($currentTime > $_SESSION['timeout']) {
    session_destroy();
    header("location:index.php");
}
// destroy previous session timeout and create new one
unset($_SESSION['timeout']);
$_SESSION['timeout'] = $currentTime + $expired;



include "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Home | - Dashboard</title>
</head>
<body>
 <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Home</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="home.php"> <i class="fa fa-home"></i> Home</a>
                </li>
            </ol>
        </section>
        <section class="content">
            <h4>Welcome
                <?php
                $sql="SELECT * FROM shops WHERE id='$ID'";
                $db->sql($sql);
                $res=$db->getResult();
                echo $res[0]['shop_name'];
            ?></h4>
            <br>
            <div class="row">   
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?php                           
                            $sql = "SELECT * FROM users";
                            $db->sql($sql);
                            $res = $db->getResult();
                            $num = $db->numRows($res);
                            echo $num; ?></h3>
                            
                            <p>Users</p>
                        </div>
                        <div class="icon"><i class="fa fa-users"></i></div>
                        <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?php                           
                            $sql = "SELECT * FROM products";
                            $db->sql($sql);
                            $res = $db->getResult();
                            $num = $db->numRows($res);
                            echo $num; ?></h3>
                            
                            <p>Total Products</p>
                        </div>
                        <div class="icon"><i class="fa fa-cube"></i></div>
                        <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div> -->
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <h3><?php                           
                            $sql = "SELECT * FROM products WHERE seller_id='$ID'";
                            $db->sql($sql);
                            $res = $db->getResult();
                            $num = $db->numRows($res);
                            echo $num; ?></h3>
                            
                            <p>My Products</p>
                        </div>
                        <div class="icon"><i class="fa fa-circle"></i></div>
                        <a href="products.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3><?php                           
                            $sql = "SELECT * FROM vendor_orders WHERE seller_id='$ID'";
                            $db->sql($sql);
                            $res = $db->getResult();
                            $num = $db->numRows($res);
                            echo $num; ?></h3>
                            
                            <p>Orders</p>
                        </div>
                        <div class="icon"><i class="fa fa-shopping-cart"></i></div>
                        <a href="orders.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3><?php                           
                            $sql = "SELECT SUM(price) AS amount FROM vendor_orders WHERE status=1 AND seller_id='$ID'";
                            $db->sql($sql);
                            $res = $db->getResult();
                            $totalamount = $res[0]['amount'];
                            echo "Rs.".$totalamount;
                            ?>
                            </h3>
                            <p>Sales</p>
                        </div>
                        <div class="icon"><i class="fa fa-money"></i></div>
                        <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            
        </section>
    </div>
    <?php include "footer.php"; ?>
</body>
</html>