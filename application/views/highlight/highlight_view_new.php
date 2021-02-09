<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">
<div class="content__inner">
<header class="content__title">
    <h1>Highlight</h1>
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
        <div class="col-md-6">
            <a href="<?php echo site_url('highlight/highlight/add_highlight') ?>"><i class="btn btn-light">Add Highlight</i></a>
        </div>
        <div class="col-md-12" align="center">
            <h2>Highlight</h2><hr>
        </div>
    </div>
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
                        <th>ID</th>
                        <th>Highlight Title</th>
                        <th>Highlight Image</th>
                        <th>Highlight Category</th>
                        <th>Highlight Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
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

<script type="text/javascript" src="<?php echo base_url().'assets/js/datatables.js'?>"></script>
<script src="<?=base_url()?>assets/vendors/bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">
    $('#sel_refactive, #sel_refinactive').select2({
        ajax: { 
            url: '<?= base_url() ?>highlight/highlight/type_category',
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
            'serverMethod': 'post',
            "order": [[ 0, "desc" ]],
            //'searching': false, // Remove default Search Control
            'ajax': {
              'url':'<?=base_url()?>highlight/highlight/active_category',
              'data': function(data){
                    data.searchRefActive = $('#sel_refactive').val();
                    data.searchNameActive = $('#searchNameActive').val();
              }
            },
            'columns': [
                { data: 'covers_id' },
                { data: 'id_goto' },
                { "render": function ( data, type, row ) {
                        var imgLink = row.poster_url
                        var html = '<img id="myImg" src="' + imgLink + '" alt="" width="128" height="72">'
                        return html;
                    }
                },
                { data: 'category_covers' },
                { data: 'type_highlight' },
                { data: 'start_date' },
                { data: 'end_date' },
                { "render": function ( data, type, row ) {
                        var html = ""
                        if(row.status == 'FALSE'){
                            html = "<button type='button' class='btn btn-outline-danger' disabled>Not Ready</button>"
                        }else{
                            html = "<button type='button' class='btn btn-outline-success' disabled>Ready</button>"
                        }
                        return html;
                    }
                },
                { "render": function ( data, type, row ) {
                        var base_url ='<?php echo base_url()?>'
                        var html  = '<div class="dropdown"><button class="btn btn-light dropdown-toggle" data-toggle="dropdown">ACTION</button><div class="dropdown-menu dropdown-menu--icon">'
                        var html = html+'<a href="'+base_url+'highlight/highlight/detail/'+row.covers_id+'" class="dropdown-item"><i class="zmdi zmdi-search-in-page zmdi-hc-fw"></i>Detail</a><a href="'+base_url+'highlight/highlight/getedit_highlight/'+row.covers_id+'?s='+row.type_goto+'" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a></div></div>'
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
</script>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>