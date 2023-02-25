<section class="content-header">
    <h1>
        Shops /
        <small><a href="home.php"><i class="fa fa-home"></i> Home</a></small>
</h1>
<ol class="breadcrumb">
        <a class="btn btn-block btn-default" href="add-shop.php"><i class="fa fa-plus-square"></i> Add New Shop</a>
    </ol>
    
</section>
    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <h4 class="box-title">Filter by Joined Date </h4>
                                <input type="date" class="form-control" id="date" name="date" value="<?php echo (isset($_GET['date'])) ? $_GET['date'] : "" ?>"></input>
                            </div>
                            <div class="form-group col-md-3">
                                <h4 class="box-title">Filter by Status</h4>
                                <select class="form-control" id="status" name="status">
                                    <option value="">--select--</option>
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id='users_table' class="table table-hover" data-toggle="table" data-url="api/get-bootstrap-table-data.php?table=shops" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams" data-sort-name="id" data-sort-order="desc" data-show-export="true" data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "users-list-<?= date('d-m-Y') ?>",
                            "ignoreColumn": ["operate"] 
                        }'>
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="shop_name" data-sortable="true">Shop Name</th>
                                    <th data-field="mobile" data-sortable="true">Mobile Number</th>
                                    <th data-field="pincode" data-sortable="true">Pincode</th>
                                    <th data-field="state" data-sortable="true">State</th>
                                    <th data-field="balance" data-sortable="true">Balance</th>
                                    <th data-field="logo">Logo</th>
                                    <th data-field="joined_date" data-sortable="true" >Joined Date</th>
                                    <th data-field="status" data-sortable="true" >Status</th>
                                    <th data-field="operate">Action</th>
                    
                    
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="separator"> </div>
        </div>
        <!-- /.row (main row) -->
    </section>

<script>
    $('#date').on('change', function() {
            id = $('#date').val();
            $('#users_table').bootstrapTable('refresh');
    });
    $('#status').on('change', function() {
            id = $('#status').val();
            $('#users_table').bootstrapTable('refresh');
    });
    // $('#community').on('change', function() {
    //     $('#users_table').bootstrapTable('refresh');
    // });

    function queryParams(p) {
        return {
            "date": $('#date').val(),
            "status": $('#status').val(),
            // "seller_id": $('#seller_id').val(),
            // "community": $('#community').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>