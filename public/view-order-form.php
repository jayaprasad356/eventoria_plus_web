<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
// session_start();
$order_id = $_GET['id'];
?>
<section class="content-header">
    <h1>View Order</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
<div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Order Detail</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                    <table class="table table-bordered">
                        <?php
                        $sql = "SELECT * FROM orders WHERE id = $order_id";
                        $db->sql($sql);
                        $res = $db->getResult();
                        $num = $db->numRows();
                        if($num >= 1){
                           
                        if($res[0]['type'] =='own'){
                            $sql = "SELECT *,packages.name AS package_name  FROM orders,packages,address,orders_timeslot WHERE orders.package_id = packages.id  AND orders.address_id = address.id AND orders.id = $order_id";
                            $db->sql($sql);
                            $res = $db->getResult();
                            ?>
                            <tr>
                                <th style="width: 200px">ID</th>
                                <td><?php echo $res[0]['id'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Order Date</th>
                                <td><?php echo $res[0]['order_date'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Event Date</th>
                                <td><?php echo $res[0]['event_date'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Package Name</th>
                                <td><?php echo $res[0]['package_name'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px"> Price</th>
                                <td><?php echo $res[0]['price'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Type</th>
                                <td><?php echo $res[0]['type'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Status</th>
                                <td><?php echo $res[0]['status'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Customer Name</th>
                                <td><?php echo $res[0]['name'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Address</th>
                                <td><?php echo $res[0]['address']; ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">District</th>
                                <td><?php echo $res[0]['district']; ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Pin Code</th>
                                <td><?php echo $res[0]['pincode']; ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">State</th>
                                <td><?php echo $res[0]['state']; ?></td>
                            </tr>
                            <?php
                        }
                        else{
                            $sql = "SELECT *,packages.name AS package_name,orders_timeslot.price AS price,venues.pincode AS pincode,orders.id AS id FROM orders,packages,venues,orders_timeslot,users WHERE orders.package_id = packages.id AND orders.venue_id = venues.id AND orders.id = orders_timeslot.order_id AND orders.id = $order_id";
                            $db->sql($sql);
                            $res = $db->getResult();
                            ?>
                            <tr>
                                <th style="width: 200px">ID</th>
                                <td><?php echo $res[0]['id'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Order Date</th>
                                <td><?php echo $res[0]['order_date'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Event Date</th>
                                <td><?php echo $res[0]['event_date'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Package Name</th>
                                <td><?php echo $res[0]['package_name'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px"> Total Price</th>
                                <td><?php echo $res[0]['price'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Type</th>
                                <td><?php echo $res[0]['type'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Status</th>
                                <td><?php echo $res[0]['status'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Customer Name</th>
                                <td><?php echo $res[0]['name'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Mobile</th>
                                <td><?php echo $res[0]['mobile'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Address</th>
                                <td><?php echo $res[0]['address']; ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Pincode</th>
                                <td><?php echo $res[0]['pincode']; ?></td>
                            </tr>
                            <?php
                            $sql = "SELECT *,orders_timeslot.price AS price  FROM orders_timeslot,orders WHERE orders.id = orders_timeslot.order_id AND orders.id = $order_id";
                            $db->sql($sql);
                            $resad = $db->getResult();
                            $index = 1;
                            foreach ($resad as $row) {
                            ?>
                            <tr>
                                <th style="width: 200px">Time Slots  <?php echo $index ?></th>
                                <td><?php echo '<b>Start Time :</b> '.$row['start_time'].'<br>'.'<b>End Time :</b> '.$row['end_time'].'<br>'.'<b>Price :</b> '.$row['price']; ?></td>
                            </tr>
                            <?php
                            $index++;
                            }
                            ?>
                        <?php
                        }
                        ?>
                        <?php
                        }
                        ?>
                
    
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <a href="orders.php" class="btn btn-sm btn-default btn-flat pull-left">Back</a>
                    </div>
                </div><!-- /.box -->
            </div>
        </div>
</section>
<div class="separator"> </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
   
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
    
</script>
<script>
    document.getElementById('valid').valueAsDate = new Date();

</script>
