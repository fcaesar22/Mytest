<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">
<div class="content__inner">
<header class="content__title">
    <h1>Management Category</h1>
    <div class="col-md-12">
    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    <?php echo $this->session->flashdata('success'); ?>
    </div>
    <?php endif; ?>
    <?php echo $this->session->flashdata('msg');?>
    </div>
</header>
<div class="card">
    <div class="card-body">
    <div class="row">
        <div class="col-md-12" align="center">
            <h2>Management Category</h2>
        </div>
    </div>
    <div class="tab-container">
        <ul class="nav nav-tabs nav-fill" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#active_art" role="tab">Active Category</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#inactive_art" role="tab">Inactive Category</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active fade show" id="active_art" role="tabpanel">
                <div id="table1" class="table-responsive">
                    <br>
                    <!-- Search filter -->
                    <div class="row">
                        <!-- Ref -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <select class="form-control" name="sel_refactive" id="sel_refactive">
                                    <option value="">Select Category Content</option>
                                </select>
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" class="form-control" id="searchNameActive" placeholder="Search Category Name">
                                <i class="form-group__bar"></i>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered" id="mytable1" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Category Name</th>
                                <th>Category Content</th>
                                <th>Category Ref</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="inactive_art" role="tabpanel">
                <div id="table2" class="table-responsive">
                    <br>
                    <!-- Search filter -->
                    <div class="row">
                        <!-- Ref -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <select class="form-control" name="sel_refinactive" id="sel_refinactive">
                                    <option value="">Select Category Content</option>
                                </select>
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" class="form-control" id="searchNameInactive" placeholder="Search Category Name">
                                <i class="form-group__bar"></i>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered" id="mytable2" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Category Name</th>
                                <th>Category Content</th>
                                <th>Category Ref</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
</div>

<!--Active banner Confirmation-->
<div class="modal fade" id="activeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-body" align="center">Are you sure?</div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a id="btn-active" class="btn btn-danger" href="#">Active</a>
            </div>
        </div>
    </div>
</div>

<!--Inactive banner Confirmation-->
<div class="modal fade" id="inactiveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-body" align="center">Are you sure?</div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a id="btn-inactive" class="btn btn-danger" href="#">Inactive</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url().'assets/js/datatables.js'?>"></script>
<script src="<?=base_url()?>assets/vendors/bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">
    $('#sel_refactive, #sel_refinactive').select2({
        ajax: { 
            url: '<?= base_url() ?>mng_category/mng_category/type_category',
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    })

    $(document).ready(function(){
        var catDataTable = $('#mytable1').DataTable({
            "dom": 'lrtip',
            'processing': true,
            'serverSide': true,
            "columnDefs": [
                { "orderable": false, "targets": 2 },
                { "orderable": false, "targets": 3 },
                { "orderable": false, "targets": 4 },
            ],
            'serverMethod': 'post',
            "order": [[ 0, "desc" ]],
            //'searching': false, // Remove default Search Control
            'ajax': {
              'url':'<?=base_url()?>mng_category/mng_category/active_category',
              'data': function(data){
                    data.searchRefActive = $('#sel_refactive').val();
                    data.searchNameActive = $('#searchNameActive').val();
              }
            },
            'columns': [
                {
                    "data": "keyword_id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'keyword_name' },
                { "render": function ( data, type, row ) {
                        var html = ""
                        if(row.keyword_parentid == ",246,"){
                            html = "DensLife&Style"
                        }
                        if(row.keyword_parentid == ",247,"){
                            html = "DensPlay"
                        }
                        if(row.keyword_parentid == ",325,"){
                            html = "DensKnowledge"
                        }
                        if(row.keyword_ref=="POD" && row.keyword_parentid == null){
                            html = "Category Podcast"
                        }
                        return html;
                    }
                },
                { "render": function ( data, type, row ) {
                        var html = ""
                        if(row.keyword_ref == "ARC"){
                            html = "Article"
                        }
                        if(row.keyword_ref != "ARC" && row.keyword_ref != "POD"){
                            html = "SocialTV"
                        }
                        if(row.keyword_ref=="POD" && row.keyword_parentid != null){
                            html = "Sub Category Podcast"
                        }
                        return html;
                    }
                },
                { "render": function ( data, type, row ) {
                        var base_url ='<?php echo base_url()?>'
                        var html  = '<div class="dropdown"><button class="btn btn-light dropdown-toggle" data-toggle="dropdown">ACTION</button><div class="dropdown-menu dropdown-menu--icon">'
                            if (row.keyword_visible=="N") {
                                var html = html + '<a onclick="activeConfirm(\''+base_url+'mng_category/mng_category/activated/'+row.keyword_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Activate Category</a>'
                            }
                            if (row.keyword_visible=="Y") {
                                var html = html + '<a onclick="inactiveConfirm(\''+base_url+'mng_category/mng_category/inactivated/'+row.keyword_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate Category</a>'
                            }
                            if(row.keyword_ref=="POD" && row.keyword_parentid == null){
                                var html = html+'<a href="'+base_url+'mng_category/mng_category/get_edit_pod/'+row.keyword_id+'" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a></div></div>'
                            }else{
                                var html = html+'<a href="'+base_url+'mng_category/mng_category/get_edit/'+row.keyword_id+'" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a></div></div>'   
                            }
                        return html
                    }
                },
            ]
        });

        $('#sel_refactive').change(function(){
            catDataTable.draw();
        });
        $('#searchNameActive').keyup(function(){
            catDataTable.draw();
        });
    });

    $(document).ready(function(){
        var catDataTable = $('#mytable2').DataTable({
            "dom": 'lrtip',
            'processing': true,
            'serverSide': true,
            "columnDefs": [
                { "orderable": false, "targets": 2 },
                { "orderable": false, "targets": 3 },
                { "orderable": false, "targets": 4 },
            ],
            'serverMethod': 'post',
            "order": [[ 0, "desc" ]],
            //'searching': false, // Remove default Search Control
            'ajax': {
              'url':'<?=base_url()?>mng_category/mng_category/inactive_category',
              'data': function(data){
                    data.searchRefInactive = $('#sel_refinactive').val();
                    data.searchNameInactive = $('#searchNameInactive').val();
              }
            },
            'columns': [
                {
                    "data": "keyword_id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'keyword_name' },
                { "render": function ( data, type, row ) {
                        var html = ""
                        if(row.keyword_parentid == ",246,"){
                            html = "DensLife&Style"
                        }
                        if(row.keyword_parentid == ",247,"){
                            html = "DensPlay"
                        }
                        if(row.keyword_parentid == ",325,"){
                            html = "DensKnowledge"
                        }
                        if(row.keyword_ref=="POD" && row.keyword_parentid == null){
                            html = "Category Podcast"
                        }
                        return html;
                    }
                },
                { "render": function ( data, type, row ) {
                        var html = ""
                        if(row.keyword_ref == "ARC"){
                            html = "Article"
                        }
                        if(row.keyword_ref != "ARC" && row.keyword_ref != "POD"){
                            html = "SocialTV"
                        }
                        if(row.keyword_ref=="POD" && row.keyword_parentid != null){
                            html = "Sub Category Podcast"
                        }
                        return html;
                    }
                },
                { "render": function ( data, type, row ) {
                        var base_url ='<?php echo base_url()?>'
                        var html  = '<div class="dropdown"><button class="btn btn-light dropdown-toggle" data-toggle="dropdown">ACTION</button><div class="dropdown-menu dropdown-menu--icon">'
                            if (row.keyword_visible=="N") {
                                var html = html + '<a onclick="activeConfirm(\''+base_url+'mng_category/mng_category/activated/'+row.keyword_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Activate Category</a>'
                            }
                            if (row.keyword_visible=="Y") {
                                var html = html + '<a onclick="inactiveConfirm(\''+base_url+'mng_category/mng_category/inactivated/'+row.keyword_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate Category</a>'
                            }
                            if(row.keyword_ref=="POD" && row.keyword_parentid == null){
                                var html = html+'<a href="'+base_url+'mng_category/mng_category/get_edit_pod/'+row.keyword_id+'" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a></div></div>'
                            }else{
                                var html = html+'<a href="'+base_url+'mng_category/mng_category/get_edit/'+row.keyword_id+'" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a></div></div>'   
                            }
                        return html
                    }
                },
            ]
        });

        $('#sel_refinactive').change(function(){
            catDataTable.draw();
        });
        $('#searchNameInactive').keyup(function(){
            catDataTable.draw();
        });
    });

    function activeConfirm(url){
        $('#btn-active').attr('href', url);
        $('#activeModal').modal();
    }

    function inactiveConfirm(url){
        $('#btn-inactive').attr('href', url);
        $('#inactiveModal').modal();
    }
</script>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>