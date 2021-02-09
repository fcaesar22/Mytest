<style type="text/css">
    span.icon-lifestyle {
        background-image: url("<?=base_url()?>assets/img/iconlifestyle.png");
    }
    span.icon-lifestyle {
        float: left;
        width: 24px;
        height: 24px;
        margin-right: 10px;
        background-repeat: no-repeat;
        background-position: center center;
        background-size: 100%;
    }
    .bg_btn {
        background: #EB5757;
        background: -webkit-linear-gradient(to right, #000000, #EB5757);
        background: linear-gradient(to right, #000000, #EB5757);
        color: white;
        width: 150px;
        border: 0px solid transparent;
    }
    .bg_btn:active {
        background: linear-gradient(to bottom, rgba(255,255,255,0.15) 0%, rgba(0,0,0,0.15) 100%), radial-gradient(at top center, rgba(255,255,255,0.40) 0%, rgba(0,0,0,0.40) 120%) #989898;
        border: 0px solid transparent;
    }
    span.icon-knowledge {
        background-image: url("<?=base_url()?>assets/img/iconknowledge.png");
    }
    span.icon-knowledge {
        float: left;
        width: 24px;
        height: 24px;
        margin-right: 10px;
        background-repeat: no-repeat;
        background-position: center center;
        background-size: 100%;
    }
    .bg_btnknowledge {
        background: #2C3E50;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #2C3E50, #4CA1AF);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #2C3E50, #4CA1AF); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        color: white;
        width: 150px;
        border: 0px solid transparent;
    }
    .bg_btnknowledge:active {
        background: linear-gradient(to bottom, rgba(255,255,255,0.15) 0%, rgba(0,0,0,0.15) 100%), radial-gradient(at top center, rgba(255,255,255,0.40) 0%, rgba(0,0,0,0.40) 120%) #989898;
        border: 0px solid transparent;
    }
    span.icon-esportarena {
        background-image: url("<?=base_url()?>assets/img/icondensplay.png");
    }
    span.icon-esportarena {
        float: left;
        width: 24px;
        height: 24px;
        margin-right: 10px;
        background-repeat: no-repeat;
        background-position: center center;
        background-size: 100%;
    }
    .bg_esportarena {
        background: #00bf8f;
        background: -webkit-linear-gradient(to right, #001510, #00bf8f);
        background: linear-gradient(to right, #001510, #00bf8f);
        color: white;
        width: 150px;
        border: 0px solid transparent;
    }
    .bg_esportarena:active {
        background: linear-gradient(to bottom, rgba(255,255,255,0.15) 0%, rgba(0,0,0,0.15) 100%), radial-gradient(at top center, rgba(255,255,255,0.40) 0%, rgba(0,0,0,0.40) 120%) #989898;
        border: 0px solid transparent;
    }
</style>

<div class="content__inner">
<header class="content__title">
    <h1>Article Dens Life & Style</h1>
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
            <a class="btn btn-light btn--icon-text" href="<?php echo site_url('denslife/denslife/add') ?>"><i class="zmdi zmdi-collection-plus zmdi-hc-fw"></i>Add Article</a>
            <a class="btn btn-light btn--icon-text" href="" id="test" onclick="test()"><i class="zmdi zmdi-collection-video zmdi-hc-fw"></i>Upload Video</a>
        </div>
        <div class="col-md-12" align="center">
            <h2>Article</h2>
        </div>
    </div>
    <div class="tab-container">
        <ul class="nav nav-tabs nav-fill" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#active_art" role="tab">Active Article</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#inactive_art" role="tab">Inactive Article</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active fade show" id="active_art" role="tabpanel">
                <button class="btn bg_btn" onclick="myFunction1()"><span class="icon icon-lifestyle"></span>DensLife & Style</button>
                <button class="btn bg_btnknowledge" onclick="myFunction2()"><span class="icon icon-knowledge"></span>DensKnowledge</button>
                <button class="btn bg_esportarena" onclick="myFunction5()"><span class="icon icon-esportarena"></span>EsportsArena</button>
                <br><br>
                <div id="table1" class="table-responsive">
                    <h4 align="center">DensLife & Style</h4>
                    <table class="table table-striped table-bordered" id="mytable1" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Article Title</th>
                                <th>Article By</th>
                                <th>Category</th>
                                <th>Status Article</th>
                                <th>Status PDF</th>
                                <th>Status Highlight</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div id="table2" class="table-responsive" style="display: none;">
                    <h4 align="center">DensKnowledge</h4>
                    <table class="table table-striped table-bordered" id="mytable2" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Article Title</th>
                                <th>Article By</th>
                                <th>Category</th>
                                <th>Status Article</th>
                                <th>Status PDF</th>
                                <th>Status Highlight</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div id="table5" class="table-responsive" style="display: none;">
                    <h4 align="center">Densnewlife</h4>
                    <table class="table table-striped table-bordered" id="mytable5" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Article Title</th>
                                <th>Article By</th>
                                <th>Category</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="inactive_art" role="tabpanel">
                <button class="btn bg_btn" onclick="myFunction3()"><span class="icon icon-lifestyle"></span>DensLife & Style</button>
                <button class="btn bg_btnknowledge" onclick="myFunction4()"><span class="icon icon-knowledge"></span>DensKnowledge</button>
                <br><br>
                <div id="table3" class="table-responsive">
                    <h4 align="center">DensLife & Style</h4>
                    <table class="table table-striped table-bordered" id="mytable3" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Article Title</th>
                                <th>Article By</th>
                                <th>Category</th>
                                <th>Status Article</th>
                                <th>Status PDF</th>
                                <th>Status Highlight</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div id="table4" class="table-responsive" style="display: none;">
                    <h4 align="center">DensKnowledge</h4>
                    <table class="table table-striped table-bordered" id="mytable4" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Article Title</th>
                                <th>Article By</th>
                                <th>Category</th>
                                <th>Status Article</th>
                                <th>Status PDF</th>
                                <th>Status Highlight</th>
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
<script type="text/javascript">
    function myFunction1() {
        var x = document.getElementById("table1");
        var y = document.getElementById("table2");
        var z = document.getElementById("table5");
        if (y.style.display === "none" && z.style.display === "none") {
            x.style.display = "block";
            y.style.display = "none";
            z.style.display = "none";
        } else {
            x.style.display = "block";
            y.style.display = "none";
            z.style.display = "none";
        }
    }

    function myFunction2() {
        var x = document.getElementById("table1");
        var y = document.getElementById("table2");
        var z = document.getElementById("table5");
        if (x.style.display === "none" && z.style.display === "none") {
            x.style.display = "none";
            y.style.display = "block";
            z.style.display = "none";
        } else {
            x.style.display = "none";
            y.style.display = "block";
            z.style.display = "none";
        }
    }

    function myFunction5() {
        var x = document.getElementById("table1");
        var y = document.getElementById("table2");
        var z = document.getElementById("table5");
        if (x.style.display === "none" && y.style.display === "none") {
            x.style.display = "none";
            y.style.display = "none";
            z.style.display = "block";
        } else {
            x.style.display = "none";
            y.style.display = "none";
            z.style.display = "block";
        }
    }

    function myFunction3() {
        var x = document.getElementById("table3");
        var y = document.getElementById("table4");
        if (y.style.display === "none") {
            x.style.display = "block";
            y.style.display = "none";
        } else {
            x.style.display = "block";
            y.style.display = "none";
        }
    }

    function myFunction4() {
        var x = document.getElementById("table3");
        var y = document.getElementById("table4");
        if (x.style.display === "none") {
            x.style.display = "none";
            y.style.display = "block";
        } else {
            x.style.display = "none";
            y.style.display = "block";
        }
    }

    $(document).ready(function() {
        $('#mytable5').DataTable( {
            "ajax": "<?=base_url()?>denslife/denslife/active_listdenslife",
            "order": [[ 0, "desc" ]],
            "columns": [
                { "data": "article_id" },
                { "data": "article_title" },
                { "data": "article_by" },
                { "data": "categories" }
            ]
        } );
    } );

    $(document).ready(function(){
        $('#mytable1').DataTable({
            'processing': true,
            'serverSide': true,
            "columnDefs": [
                { "orderable": false, "targets": 0 },
                { "orderable": false, "targets": 1 },
                { "orderable": false, "targets": 2 },
                { "orderable": false, "targets": 3 },
                { "orderable": false, "targets": 4 },
                { "orderable": false, "targets": 5 },
                { "orderable": false, "targets": 6 },
                { "orderable": false, "targets": 7 },
            ],
            'serverMethod': 'post',
            'ajax': {
              'url':'<?=base_url()?>denslife/denslife/active_listdenslife'
            },
            'columns': [
                { data: 'article_id' },
                { data: 'article_title' },
                { data: 'article_by' },
                { data: 'categories' },
                { "render": function ( data, type, row ) {
                        var html = ""

                        if(row.active == "N"){
                            html = "<button type='button' class='btn btn-outline-danger' disabled>Inactive</button>"
                        }else{
                            html = "<button type='button' class='btn btn-outline-success' disabled>Active</button>"
                        }

                        return html;
                    }
                },
                { "render": function ( data, type, row ) {
                        var html = ""

                        if(row.pdf_url == null){
                            html = "<button type='button' class='btn btn-outline-danger' disabled>Not Ready</button>"
                        }else{
                            html = "<button type='button' class='btn btn-outline-success' disabled>Ready</button>"
                        }

                        return html;
                    }
                },
                { "render": function ( data, type, row ) {
                        var html = ""

                        if(row.status_highlight == "N"){
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
                            if (row.active=="N") {
                                var html = html + '<a onclick="activeConfirm(\''+base_url+'denslife/denslife/activated/'+row.article_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Activete Article</a>'
                            }
                            if (row.active=="Y") {
                                var html = html + '<a onclick="inactiveConfirm(\''+base_url+'denslife/denslife/inactivated/'+row.article_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate Article</a>'
                            }
                            if (row.categories.includes("Food & Recipes")) {
                                var html = html + '<a onclick="view_pdf(\''+base_url+'denslife/denslife/viewpdf/'+row.article_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-search-in-file zmdi-hc-fw"></i>Generate PDF</a>'
                            }
                        var html = html+'<a href="'+base_url+'denslife/denslife/detail/'+row.article_id+'" class="dropdown-item"><i class="zmdi zmdi-search-in-page zmdi-hc-fw"></i>Detail</a><a href="'+base_url+'denslife/denslife/get_edit/'+row.article_id+'" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a></div></div>'
                        return html
                    }
                },
            ]
        });

        $('#mytable2').DataTable({
            'processing': true,
            'serverSide': true,
            "order": [[ 0, 'desc' ]],
            "columnDefs": [
                { "orderable": false, "targets": 0 },
                { "orderable": false, "targets": 1 },
                { "orderable": false, "targets": 2 },
                { "orderable": false, "targets": 3 },
                { "orderable": false, "targets": 4 },
                { "orderable": false, "targets": 5 },
                { "orderable": false, "targets": 6 },
                { "orderable": false, "targets": 7 },
            ],
            'serverMethod': 'post',
            'ajax': {
              'url':'<?=base_url()?>denslife/denslife/active_listdensknowledge'
            },
            'columns': [
                { data: 'article_id' },
                { data: 'article_title' },
                { data: 'article_by' },
                { data: 'categories' },
                { "render": function ( data, type, row ) {
                        var html = ""

                        if(row.active == "N"){
                            html = "<button type='button' class='btn btn-outline-danger' disabled>Inactive</button>"
                        }else{
                            html = "<button type='button' class='btn btn-outline-success' disabled>Active</button>"
                        }

                        return html;
                    }
                },
                { "render": function ( data, type, row ) {
                        var html = ""

                        if(row.pdf_url == null){
                            html = "<button type='button' class='btn btn-outline-danger' disabled>Not Ready</button>"
                        }else{
                            html = "<button type='button' class='btn btn-outline-success' disabled>Ready</button>"
                        }

                        return html;
                    }
                },
                { "render": function ( data, type, row ) {
                        var html = ""

                        if(row.status_highlight == "N"){
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
                            if (row.active=="N") {
                                var html = html + '<a onclick="activeConfirm(\''+base_url+'denslife/denslife/activated/'+row.article_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Activete Article</a>'
                            }
                            if (row.active=="Y") {
                                var html = html + '<a onclick="inactiveConfirm(\''+base_url+'denslife/denslife/inactivated/'+row.article_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate Article</a>'
                            }
                            if (row.categories.includes("Food & Recipes")) {
                                var html = html + '<a onclick="view_pdf(\''+base_url+'denslife/denslife/viewpdf/'+row.article_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-search-in-file zmdi-hc-fw"></i>Generate PDF</a>'
                            }
                        var html = html+'<a href="'+base_url+'denslife/denslife/detail/'+row.article_id+'" class="dropdown-item"><i class="zmdi zmdi-search-in-page zmdi-hc-fw"></i>Detail</a><a href="'+base_url+'denslife/denslife/get_edit/'+row.article_id+'" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a></div></div>'
                        return html
                    }
                },
            ]
        });

        $('#mytable3').DataTable({
            'processing': true,
            'serverSide': true,
            "order": [[ 0, 'desc' ]],
            "columnDefs": [
                { "orderable": false, "targets": 0 },
                { "orderable": false, "targets": 1 },
                { "orderable": false, "targets": 2 },
                { "orderable": false, "targets": 3 },
                { "orderable": false, "targets": 4 },
                { "orderable": false, "targets": 5 },
                { "orderable": false, "targets": 6 },
                { "orderable": false, "targets": 7 },
            ],
            'serverMethod': 'post',
            'ajax': {
              'url':'<?=base_url()?>denslife/denslife/inactive_listdenslife'
            },
            'columns': [
                { data: 'article_id' },
                { data: 'article_title' },
                { data: 'article_by' },
                { data: 'categories' },
                { "render": function ( data, type, row ) {
                        var html = ""

                        if(row.active == "N"){
                            html = "<button type='button' class='btn btn-outline-danger' disabled>Inactive</button>"
                        }else{
                            html = "<button type='button' class='btn btn-outline-success' disabled>Active</button>"
                        }

                        return html;
                    }
                },
                { "render": function ( data, type, row ) {
                        var html = ""

                        if(row.pdf_url == null){
                            html = "<button type='button' class='btn btn-outline-danger' disabled>Not Ready</button>"
                        }else{
                            html = "<button type='button' class='btn btn-outline-success' disabled>Ready</button>"
                        }

                        return html;
                    }
                },
                { "render": function ( data, type, row ) {
                        var html = ""

                        if(row.status_highlight == "N"){
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
                            if (row.active=="N") {
                                var html = html + '<a onclick="activeConfirm(\''+base_url+'denslife/denslife/activated/'+row.article_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Activete Article</a>'
                            }
                            if (row.active=="Y") {
                                var html = html + '<a onclick="inactiveConfirm(\''+base_url+'denslife/denslife/inactivated/'+row.article_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate Article</a>'
                            }
                            if (row.categories.includes("Food & Recipes")) {
                                var html = html + '<a onclick="view_pdf(\''+base_url+'denslife/denslife/viewpdf/'+row.article_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-search-in-file zmdi-hc-fw"></i>Generate PDF</a>'
                            }
                        var html = html+'<a href="'+base_url+'denslife/denslife/detail/'+row.article_id+'" class="dropdown-item"><i class="zmdi zmdi-search-in-page zmdi-hc-fw"></i>Detail</a><a href="'+base_url+'denslife/denslife/get_edit/'+row.article_id+'" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a></div></div>'
                        return html
                    }
                },
            ]
        });

        $('#mytable4').DataTable({
            'processing': true,
            'serverSide': true,
            "order": [[ 0, 'desc' ]],
            "columnDefs": [
                { "orderable": false, "targets": 0 },
                { "orderable": false, "targets": 1 },
                { "orderable": false, "targets": 2 },
                { "orderable": false, "targets": 3 },
                { "orderable": false, "targets": 4 },
                { "orderable": false, "targets": 5 },
                { "orderable": false, "targets": 6 },
                { "orderable": false, "targets": 7 },
            ],
            'serverMethod': 'post',
            'ajax': {
              'url':'<?=base_url()?>denslife/denslife/inactive_listdensknowledge'
            },
            'columns': [
                { data: 'article_id' },
                { data: 'article_title' },
                { data: 'article_by' },
                { data: 'categories' },
                { "render": function ( data, type, row ) {
                        var html = ""

                        if(row.active == "N"){
                            html = "<button type='button' class='btn btn-outline-danger' disabled>Inactive</button>"
                        }else{
                            html = "<button type='button' class='btn btn-outline-success' disabled>Active</button>"
                        }

                        return html;
                    }
                },
                { "render": function ( data, type, row ) {
                        var html = ""

                        if(row.pdf_url == null){
                            html = "<button type='button' class='btn btn-outline-danger' disabled>Not Ready</button>"
                        }else{
                            html = "<button type='button' class='btn btn-outline-success' disabled>Ready</button>"
                        }

                        return html;
                    }
                },
                { "render": function ( data, type, row ) {
                        var html = ""

                        if(row.status_highlight == "N"){
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
                            if (row.active=="N") {
                                var html = html + '<a onclick="activeConfirm(\''+base_url+'denslife/denslife/activated/'+row.article_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Activete Article</a>'
                            }
                            if (row.active=="Y") {
                                var html = html + '<a onclick="inactiveConfirm(\''+base_url+'denslife/denslife/inactivated/'+row.article_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate Article</a>'
                            }
                            if (row.categories.includes("Food & Recipes")) {
                                var html = html + '<a onclick="view_pdf(\''+base_url+'denslife/denslife/viewpdf/'+row.article_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-search-in-file zmdi-hc-fw"></i>Generate PDF</a>'
                            }
                        var html = html+'<a href="'+base_url+'denslife/denslife/detail/'+row.article_id+'" class="dropdown-item"><i class="zmdi zmdi-search-in-page zmdi-hc-fw"></i>Detail</a><a href="'+base_url+'denslife/denslife/get_edit/'+row.article_id+'" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a></div></div>'
                        return html
                    }
                },
            ]
        });
    });

    // $(document).ready(function(){
    //     $('#mytable').DataTable();
    // });

    function test() { 
        window.open("http://aid.digdaya.co.id/uploader", "_blank"); 
    } 

    function view_pdf(url){
        window.open(url);
    }

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