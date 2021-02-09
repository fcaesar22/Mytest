<div class="content__inner">
<header class="content__title">
    <h1>Social TV</h1>
    <div class="col-md-12">
        <?php echo $this->session->flashdata('msg');?>
    </div>
</header>
<div class="card">
    <div class="card-body">
    <div class="row">
        <div class="col-md-6">
            <a href="<?php echo site_url('socialtv/socialtv/add_socialtv') ?>"><i class="btn btn-light">Add Social TV</i></a>
        </div>
        <div class="col-md-12" align="center">
            <h4 class="card-title">Social TV</h4>
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
                    <button class="btn btn-light" onclick="myFunction1()">DensLife & Style</button>
                    <button class="btn btn-light" onclick="myFunction2()">DensKnowledge</button>
                    <br><br>
                    <div id="table1" class="table-responsive">
                        <h4 align="center">DensLife & Style</h4>
                        <table class="table table-striped table-bordered" id="mytable1" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Social TV Name</th>
                                    <th>Social TV Category</th>
                                    <th>Social TV Photo</th>
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
                                    <th>No.</th>
                                    <th>Social TV Name</th>
                                    <th>Social TV Category</th>
                                    <th>Social TV Photo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="inactive_art" role="tabpanel">
                    <button class="btn btn-light" onclick="myFunction3()">DensLife & Style</button>
                    <button class="btn btn-light" onclick="myFunction4()">DensKnowledge</button>
                    <br><br>
                    <div id="table3" class="table-responsive">
                        <h4 align="center">DensLife & Style</h4>
                        <table class="table table-striped table-bordered" id="mytable3" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Social TV Name</th>
                                    <th>Social TV Category</th>
                                    <th>Social TV Photo</th>
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
                                    <th>No.</th>
                                    <th>Social TV Name</th>
                                    <th>Social TV Category</th>
                                    <th>Social TV Photo</th>
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
        if (y.style.display === "none") {
            x.style.display = "block";
            y.style.display = "none";
        } else {
            x.style.display = "block";
            y.style.display = "none";
        }
    }

    function myFunction2() {
        var x = document.getElementById("table1");
        var y = document.getElementById("table2");
        if (x.style.display === "none") {
            x.style.display = "none";
            y.style.display = "block";
        } else {
            x.style.display = "none";
            y.style.display = "block";
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

    function activeConfirm(url){
        $('#btn-active').attr('href', url);
        $('#activeModal').modal();
    }

    function inactiveConfirm(url){
        $('#btn-inactive').attr('href', url);
        $('#inactiveModal').modal();
    }

    $(document).ready(function(){
        $('#mytable1').DataTable({
            'processing': true,
            'serverSide': true,
            "order": [[ 0, 'desc' ]],
            "columnDefs": [
                { "orderable": false, "targets": 3 }
            ],
            'serverMethod': 'post',
            'ajax': {
              'url':'<?=base_url()?>socialtv/socialtv/active_listdenslife'
            },
            'columns': [
                { data: 'socialtv_id' },
                { data: 'socialtv_name' },
                { data: 'categories' },
                { "render": function ( data, type, row ) {
                        var imgLink = row.poster_url
                        var html = '<img id="myImg" src="' + imgLink + '" alt="" width="128" height="72">'
                        return html;
                    }
                },
                { "render": function ( data, type, row ) {
                        var base_url ='<?php echo base_url()?>'
                        var html  = '<div class="dropdown"><button class="btn btn-light dropdown-toggle" data-toggle="dropdown">ACTION</button><div class="dropdown-menu dropdown-menu--icon">'
                            if (row.visible=="N") {
                                var html = html + '<a onclick="activeConfirm(\''+base_url+'socialtv/socialtv/activated/'+row.socialtv_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Actived Social TV</a>'
                            } else {
                                var html = html + '<a onclick="inactiveConfirm(\''+base_url+'socialtv/socialtv/inactivated/'+row.socialtv_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate Social TV</a>'
                            }
                        var html = html+'<a href="'+base_url+'socialtv/socialtv/detail/'+row.socialtv_id+'" class="dropdown-item"><i class="zmdi zmdi-search-in-page zmdi-hc-fw"></i>Detail</a><a href="'+base_url+'socialtv/socialtv/getedit_socialtv/'+row.socialtv_id+'" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a></div></div>'
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
                { "orderable": false, "targets": 3 }
            ],
            'serverMethod': 'post',
            'ajax': {
              'url':'<?=base_url()?>socialtv/socialtv/active_listdensknowledge'
            },
            'columns': [
                { data: 'socialtv_id' },
                { data: 'socialtv_name' },
                { data: 'categories' },
                { "render": function ( data, type, row ) {
                        var imgLink = row.poster_url
                        var html = '<img id="myImg" src="' + imgLink + '" alt="" width="128" height="72">'
                        return html;
                    }
                },
                { "render": function ( data, type, row ) {
                        var base_url ='<?php echo base_url()?>'
                        var html  = '<div class="dropdown"><button class="btn btn-light dropdown-toggle" data-toggle="dropdown">ACTION</button><div class="dropdown-menu dropdown-menu--icon">'
                            if (row.visible=="N") {
                                var html = html + '<a onclick="activeConfirm(\''+base_url+'socialtv/socialtv/activated/'+row.socialtv_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Actived Social TV</a>'
                            } else {
                                var html = html + '<a onclick="inactiveConfirm(\''+base_url+'socialtv/socialtv/inactivated/'+row.socialtv_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate Social TV</a>'
                            }
                        var html = html+'<a href="'+base_url+'socialtv/socialtv/detail/'+row.socialtv_id+'" class="dropdown-item"><i class="zmdi zmdi-search-in-page zmdi-hc-fw"></i>Detail</a><a href="'+base_url+'socialtv/socialtv/getedit_socialtv/'+row.socialtv_id+'" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a></div></div>'
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
                { "orderable": false, "targets": 3 }
            ],
            'serverMethod': 'post',
            'ajax': {
              'url':'<?=base_url()?>socialtv/socialtv/inactive_listdenslife'
            },
            'columns': [
                { data: 'socialtv_id' },
                { data: 'socialtv_name' },
                { data: 'categories' },
                { "render": function ( data, type, row ) {
                        var imgLink = row.poster_url
                        var html = '<img id="myImg" src="' + imgLink + '" alt="" width="128" height="72">'
                        return html;
                    }
                },
                { "render": function ( data, type, row ) {
                        var base_url ='<?php echo base_url()?>'
                        var html  = '<div class="dropdown"><button class="btn btn-light dropdown-toggle" data-toggle="dropdown">ACTION</button><div class="dropdown-menu dropdown-menu--icon">'
                            if (row.visible=="N") {
                                var html = html + '<a onclick="activeConfirm(\''+base_url+'socialtv/socialtv/activated/'+row.socialtv_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Actived Social TV</a>'
                            } else {
                                var html = html + '<a onclick="inactiveConfirm(\''+base_url+'socialtv/socialtv/inactivated/'+row.socialtv_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate Social TV</a>'
                            }
                        var html = html+'<a href="'+base_url+'socialtv/socialtv/detail/'+row.socialtv_id+'" class="dropdown-item"><i class="zmdi zmdi-search-in-page zmdi-hc-fw"></i>Detail</a><a href="'+base_url+'socialtv/socialtv/getedit_socialtv/'+row.socialtv_id+'" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a></div></div>'
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
                { "orderable": false, "targets": 3 }
            ],
            'serverMethod': 'post',
            'ajax': {
              'url':'<?=base_url()?>socialtv/socialtv/inactive_listdensknowledge'
            },
            'columns': [
                { data: 'socialtv_id' },
                { data: 'socialtv_name' },
                { data: 'categories' },
                { "render": function ( data, type, row ) {
                        var imgLink = row.poster_url
                        var html = '<img id="myImg" src="' + imgLink + '" alt="" width="128" height="72">'
                        return html;
                    }
                },
                { "render": function ( data, type, row ) {
                        var base_url ='<?php echo base_url()?>'
                        var html  = '<div class="dropdown"><button class="btn btn-light dropdown-toggle" data-toggle="dropdown">ACTION</button><div class="dropdown-menu dropdown-menu--icon">'
                            if (row.visible=="N") {
                                var html = html + '<a onclick="activeConfirm(\''+base_url+'socialtv/socialtv/activated/'+row.socialtv_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Actived Social TV</a>'
                            } else {
                                var html = html + '<a onclick="inactiveConfirm(\''+base_url+'socialtv/socialtv/inactivated/'+row.socialtv_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate Social TV</a>'
                            }
                        var html = html+'<a href="'+base_url+'socialtv/socialtv/detail/'+row.socialtv_id+'" class="dropdown-item"><i class="zmdi zmdi-search-in-page zmdi-hc-fw"></i>Detail</a><a href="'+base_url+'socialtv/socialtv/getedit_socialtv/'+row.socialtv_id+'" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a></div></div>'
                        return html
                    }
                },
            ]
        });
    });
</script>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>