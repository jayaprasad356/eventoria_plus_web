<section class="content-header">
    <h1>
        Vendor Orders /
        <small><a href="home.php"><i class="fa fa-home"></i> Home</a></small>
</h1>
    
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
                                    <h4 class="box-title">Filter by Status</h4>
                                    <select id='status' name="status" class='form-control'>
                                        <option value="">select</option>
                                        <option value='0'>Booked</option>
                                        <option value='1'>Confirmed</option>
                                        <option value='2'>Completed</option>
                                        <option value='3'>Cancelled</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-3">
                                <h4 class="box-title">Filter by Ordered Date </h4><br>
                                <input type="date" class="form-control" name="date" id="date" />
                            </div>
                            <div class="form-group col-md-3">
                                    <h4 class="box-title">Filter by Month </h4>
                                        <select id='month' name="month" class='form-control'>
                                            <option value="">select</option>
                                                <?php
                                                $sql = "SELECT id,month FROM `months`";
                                                $db->sql($sql);
                                                $result = $db->getResult();
                                                foreach ($result as $value) {
                                                ?>
                                                    <option value='<?= $value['id'] ?>'><?= $value['month'] ?></option>
                                            <?php } ?>
                                        </select>
                            </div>
                            <div class="form-group col-md-3">
                                <h4 class="box-title">Filter by Year </h4><br>
                                <select id='year' name="year" class='form-control'>
                                    <option value="">select</option>
                                        <?php
                                        $sql = "SELECT id,year FROM `years`";
                                        $db->sql($sql);
                                        $result = $db->getResult();
                                        foreach ($result as $value) {
                                        ?>
                                            <option value='<?= $value['year'] ?>'><?= $value['year'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                    <h4 class="box-title">From Date </h4>
                                    <input type="date" class="form-control" name="from_date" id="from_date" >
                                    </select> 
                            </div>
                            <div class="form-group col-md-3">
                                    <h4 class="box-title">To Date </h4>
                                    <input type="date" class="form-control" name="to_date" id="to_date">
                                    </select> 
                            </div>
                            <div class="form-group col-md-3">
                                <h4 class="box-title">Filter by Sellers </h4>
                                    <select id='seller_id' name="seller_id" class='form-control'>
                                    <option value=''>All</option>
                                    
                                            <?php
                                            $sql = "SELECT id,shop_name FROM `shops`";
                                            $db->sql($sql);
                                            $result = $db->getResult();
                                            foreach ($result as $value) {
                                            ?>
                                                <option value='<?= $value['id'] ?>'><?= $value['shop_name'] ?></option>
                                        <?php } ?>
                                    </select>
                            </div>
                        </div>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id='users_table' class="table table-hover" data-toggle="table" data-url="api/get-bootstrap-table-data.php?table=vendor_orders" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-show-footer="true" data-filter-control="true" data-query-params="queryParams" data-sort-name="id" data-sort-order="desc" data-show-export="true" data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "vendor_orders-list-<?= date('d-m-Y') ?>",
                            "ignoreColumn": ["operate"] 
                        }'>
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="mobile" data-sortable="true">Mobile Number</th>
                                    <th data-field="product_name" data-sortable="true">Product Name</th>
                                    <th data-field="shop_name" data-sortable="true">Shop Name</th>
                                    <th data-field="quantity" data-sortable="true" data-footer-formatter="totalFormatter">Quantity</th>
                                    <th data-field="price" data-sortable="true" data-footer-formatter="priceFormatter">Price</th>
                                    <th data-field="image">Image</th>
                                    <th data-field="order_date" data-sortable="true">Order Date</th>
                                    <th data-field="status" data-sortable="true" >Status</th>
                                    <th data-field="view">View</th>
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
    $('#month').on('change', function() {
        id = $('#month').val();
        $('#users_table').bootstrapTable('refresh');
    });
    $('#year').on('change', function() {
        id = $('#year').val();
        $('#users_table').bootstrapTable('refresh');
    });
    $('#from_date').on('change', function() {
        id = $('#from_date').val();
        $('#users_table').bootstrapTable('refresh');
    });
    $('#to_date').on('change', function() {
        id = $('#to_date').val();
        $('#users_table').bootstrapTable('refresh');
    });
    $('#status').on('change', function() {
        id = $('#status').val();
        $('#users_table').bootstrapTable('refresh');
    });
    $('#seller_id').on('change', function() {
            id = $('#seller_id').val();
            $('#users_table').bootstrapTable('refresh');
    });

    function queryParams(p) {
        return {
            "date": $('#date').val(),
            "month": $('#month').val(),
            "year": $('#year').val(),
            "from_date": $('#from_date').val(),
            "to_date": $('#to_date').val(),
            "status": $('#status').val(),
            "seller_id": $('#seller_id').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
    function totalFormatter() {
        return '<span style="color:green;font-weight:bold;font-size:large;">TOTAL</span>'
    }

    var total = 0;

    function priceFormatter(data) {
        var field = this.field
        return '<span style="color:green;font-weight:bold;font-size:large;"> ' + data.map(function(row) {
                return +row[field]
            })
            .reduce(function(sum, i) {
                return sum + i
            }, 0);
    }

</script>
<script>
    $(document).ready(function () {
        $('#seller_id').select2({
        width: 'element',
        placeholder: 'Type in name to search',

    });
    });

    if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}

</script>