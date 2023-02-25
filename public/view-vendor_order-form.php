<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
// session_start();
$order_id = $_GET['id'];
$sql = "SELECT *,vendor_orders.id AS id,vendor_orders.status AS status,users.name AS name,address.address AS address,address.district AS district,address.pincode AS pincode,users.mobile AS mobile,vendor_orders.price AS price,vendor_orders.quantity,shops.shop_name,shops.mobile AS shop_mobile,shops.name AS seller_name,shops.latitude,shops.longitude,shops.pincode AS shop_pincode,shops.street,shops.account_number,shops.bank_ifsc_code,shops.holder_name,shops.bank_name,products.name AS product_name,products.unit,products.measurement,categories.name AS category_name FROM `vendor_orders`,`products`,`users`,`address`,`shops`,`categories` WHERE vendor_orders.user_id=users.id AND vendor_orders.product_id=products.id AND categories.id=products.category_id AND vendor_orders.address_id=address.id  AND vendor_orders.id = '$order_id'";
$db->sql($sql);
$res = $db->getResult();
?>
<section class="content-header">
    <h1>View Vendor Order</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Order Detail</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width:200px;color:Blue;">Customer Details:</th>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">Name</th>
                                        <td><?php echo $res[0]['name'] ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">Mobile</th>
                                        <td><?php echo $res[0]['mobile'] ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">Address</th>
                                        <td><?php echo $res[0]['address'] ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">PinCode</th>
                                        <td><?php echo $res[0]['pincode'] ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">District</th>
                                        <td><?php echo $res[0]['district'] ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width:200px;color:violet;">Product Details:</th>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">Order ID</th>
                                        <td><?php echo $res[0]['id'] ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">Order Date</th>
                                        <td><?php echo $res[0]['order_date'] ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">Category</th>
                                        <td><?php echo $res[0]['category_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">Product Name</th>
                                        <td><?php echo $res[0]['product_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">Quantity</th>
                                        <td><?php echo $res[0]['quantity'] ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">Price</th>
                                        <td><?php echo $res[0]['price'] ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">Status</th>
                                        <td>
                                            <?php 
                                                if($res[0]['status']==0){ ?>
                                                     <p class="text text-info">Booked</p>
                                                <?php
                                                }
                                                elseif($res[0]['status']==1){?>
                                                    <p class="text text-success">Confirmed</p>
                                                <?php
                                                }
                                                elseif($res[0]['status']==2){?>
                                                    <p class="text text-primary">Completed</p>
                                                <?php
                                                }
                                                else{ ?>
                                                    <p class="text text-danger">Cancelled</p>
                                                <?php
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width:200px;color:Blue;">Shop Details:</th>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">Seller Name</th>
                                        <td><?php echo $res[0]['seller_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">Shop Name</th>
                                        <td><?php echo $res[0]['shop_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">Mobile</th>
                                        <td><?php echo $res[0]['shop_mobile'] ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">Shop PinCode</th>
                                        <td><?php echo $res[0]['shop_pincode'] ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">Street</th>
                                        <td><?php echo $res[0]['street'] ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">Latitude</th>
                                        <td><?php echo $res[0]['latitude'] ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">Longitude</th>
                                        <td><?php echo $res[0]['longitude'] ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">Account Number</th>
                                        <td><?php echo $res[0]['account_number'] ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">Bank IFSC Code</th>
                                        <td><?php echo $res[0]['bank_ifsc_code'] ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">Holder Name</th>
                                        <td><?php echo $res[0]['holder_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 200px">Bank Name</th>
                                        <td><?php echo $res[0]['bank_name'] ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                        <?php
                        $order_id = $_GET['id'];
                        if (isset($_POST['btnUpdate'])) {
                            
                            $status = $db->escapeString($_POST['status']);    
                        
                                $sql = "UPDATE vendor_orders SET `status` = '$status' WHERE id = '" . $order_id . "'";
                                $db->sql($sql);
                                $order_result = $db->getResult();
                                if (!empty($order_result)) {
                                    $order_result = 0;
                                } else {
                                    $order_result = 1;
                                }
                                if ($order_result == 1 ) {
                                    $error['add_menu'] = "<section class='content-header'>
                                                                        <span id='success' class='label label-success'>Updated Successfully</span>
                                                                        
                                                                        </section>";
                                } else {
                                    $error['add_menu'] = " <span class='label label-danger'>Failed</span>";
                                }
                        
                        }
                        $sql_query = "SELECT status FROM vendor_orders WHERE id = '" . $order_id . "'";
                        $db->sql($sql_query);
                        
                        $res = $db->getResult();
                        
                        ?>
                        <section class="content-header">
                            <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
                        </section>
                        <form id='add_product_form' method="post" enctype="multipart/form-data">
                            <div class="box-body">
                                    <div class="form-group" >
                                    <label class="control-label">Status</label> <i class="text-danger asterik">*</i><br>
                                        <div id="status" class="btn-group">
                                            <label class="btn btn-info" data-toggle-class="btn-default" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="status" value="0" <?= ($res[0]['status'] == 0) ? 'checked' : ''; ?>> Booked
                                            </label>
                                            <label class="btn btn-success" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="status" value="1" <?= ($res[0]['status'] == 1) ? 'checked' : ''; ?>> Confirmed
                                            </label>
                                            <label class="btn btn-primary" data-toggle-class="btn-default" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="status" value="2" <?= ($res[0]['status'] == 2) ? 'checked' : ''; ?>> Completed
                                            </label>
                                            <label class="btn btn-danger" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="status" value="3" <?= ($res[0]['status'] == 3) ? 'checked' : ''; ?>> Cancelled
                                            </label>
                                        </div>
                                    </div>
                            </div>
                            <div class="box-footer">
                                <input type="submit" class="btn-primary btn" value="Update" name="btnUpdate" />
                            </div>
                        </form>
                </div>
                <!--box--->
            </div>
        
        </div>
</section>
<div class="separator"> </div>

<script>
    if ($("#success").text() == "Updated Successfully")
    {
        setTimeout(showpanel, 1000);
        
    }
    function showpanel() {     
        window.location.replace("vendor_orders.php");
    }
</script>
