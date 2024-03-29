<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

?>
<?php
if (isset($_POST['btnAdd'])) {


        $state = $db->escapeString($fn->xss_clean($_POST['state']));
        $district = $db->escapeString($fn->xss_clean($_POST['district']));
        $pincode = $db->escapeString($fn->xss_clean($_POST['pincode']));
      

        if (empty($pincode)) {
            $error['pincode'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($district)) {
            $error['district'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($state)) {
            $error['state'] = " <span class='label label-danger'>Required!</span>";
        }
      

        if (!empty($pincode) && !empty($district) && !empty($state)) {
        
            $sql_query = "INSERT INTO deliver_pincodes (state,district,pincode)VALUE('$state','$district','$pincode')";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                $error['add_pincode'] = " <section class='content-header'><span class='label label-success'>Pincode Added Successfully</span></section>";
            } else {
                $error['add_pincode'] = " <span class='label label-danger'>Failed To add pincode</span>";
            }
            }
        }
?>
<section class="content-header">
    <h1>Add Pincode<small><a href='pincodes.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Pincodes</a></small></h1>

    <?php echo isset($error['add_pincode']) ? $error['add_pincode'] : ''; ?>
       <ol class="breadcrumb">
            <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
        </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-8">
           
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">

                </div><!-- /.box-header -->
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>
                <!-- form start -->
                <form name="add_pincode" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                       <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                        <label for="exampleInputEmail1"> State</label> <i class="text-danger asterik">*</i><?php echo isset($error['state']) ? $error['state'] : ''; ?>
                                        <input type="text" class="form-control" name="state" required>
                                </div>
                                <div class="col-md-6">
                                        <label for="exampleInputEmail1"> District</label> <i class="text-danger asterik">*</i><?php echo isset($error['district']) ? $error['district'] : ''; ?>
                                        <input type="text" class="form-control" name="district" required>
                                </div>
                             </div>          
                        </div>    
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-8">
                                        <label for="exampleInputEmail1"> Pincode</label> <i class="text-danger asterik">*</i><?php echo isset($error['pincode']) ? $error['pincode'] : ''; ?>
                                        <input type="number" class="form-control" name="pincode" required>

                                </div>
                             </div>          
                        </div>               
                    </div>
                  
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnAdd">Add</button>
                        <input type="reset" class="btn-warning btn" value="Clear" />
                    </div>

                </form>

            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>
<?php $db->disconnect(); ?>