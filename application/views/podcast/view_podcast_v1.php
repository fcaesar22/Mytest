<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/flatpickr/dist/flatpickr.min.css" />
<link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">
<div class="content__inner">
<header class="content__title">
    <h1>Podcast</h1>
    <div class="col-md-12">
        <?php echo $this->session->flashdata('msg');?>
    </div>
</header>
<style type="text/css">
    td {text-align: center; vertical-align: middle !important;}
    th {text-align: center; vertical-align: middle;}
    .flatpickr-calendar {
        margin-top: -200px;
    }
</style>
<div class="card">
    <div class="card-body">
    <div class="row">
        <div class="col-md-6">
            <a href="<?php echo site_url('podcast/podcast_v1/add_podcast') ?>"><i class="btn btn-light">Add Podcast</i></a>
        </div>
        <div class="col-md-12" align="center">
            <h4 class="card-title">Podcast</h4>
        </div>
    </div>
        <div class="tab-container">
            <ul class="nav nav-tabs nav-fill" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#active_pod" role="tab">Active Podcast</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#inactive_pod" role="tab">Inactive Podcast</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active fade show" id="active_pod" role="tabpanel">
                    <div id="table1" class="table-responsive">
                        <table class="table table-striped table-inverse table-bordered mb-0" id="mytable1" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Podcast Image</th>
                                    <th>Podcast Name</th>
                                    <th>Podcast Category</th>
                                    <th>Podcast Recommendation</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="inactive_pod" role="tabpanel">
                    <div id="table2" class="table-responsive">
                        <table class="table table-striped table-bordered" id="mytable2" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Podcast Image</th>
                                    <th>Podcast Name</th>
                                    <th>Podcast Category</th>
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

<div class="modal fade show" id="modalRecom" tabindex="-1" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="myform" action="<?php echo base_url("podcast/podcast_v1/save_podcast_recom"); ?>" method="post">
                <div class="modal-header" style="justify-content: center;">
                    <h5 class="modal-title">Recommendation Podcast</h5>
                </div>
                <hr>
                <div class="modal-body">
                <br>
                    <div class="col-sm-6">
                        <label>Start Schedule Time</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                            <div class="form-group">
                                <input type="text" name="datetimepickerstart" id="datetimepickerstart" class="form-control date-picker flatpickr-input" placeholder="Pick a date" autocomplete="off" required="">
                                <i class="form-group__bar"></i>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-sm-6">
                        <label>End Schedule Time</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                            <div class="form-group">
                                <input type="text" name="datetimepickerend" id="datetimepickerend" class="form-control date-picker flatpickr-input" placeholder="Pick a date" autocomplete="off" required="">
                                <i class="form-group__bar"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="podcast_id" id="podcast_id" value="">
                    <button type="submit" class="btn btn-link">Save</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url().'assets/js/datatables.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/vendors/bower_components/flatpickr/dist/flatpickr.min.js'?>"></script>
<script type="text/javascript">
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
                { "orderable": false, "targets": 3 },
                { "orderable": false, "targets": 4 }
            ],
            'serverMethod': 'post',
            'ajax': {
              'url':'<?=base_url()?>podcast/podcast_v1/active_podcast'
            },
            'columns': [
                { data: 'podcast_id' },
                { "render": function ( data, type, row ) {
                        var imgLink = row.podcast_image
                        var html = '<img id="myImg" src="' + imgLink + '" alt="" width="80" height="80">'
                        return html;
                    }
                },
                { data: 'podcast_name' },
                { data: 'categories' },
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
                            if (row.start_periode != null && row.end_periode != null) {
                                var html = html + '<a onclick="getIDS(\''+row.podcast_id+'\', \''+row.start_periode+'\', \''+row.end_periode+'\')" href="#" class="dropdown-item" data-toggle="modal" data-target="#modalRecom"><i class="zmdi zmdi-calendar zmdi-hc-fw" ></i>Recommendation</a>'
                            } else {
                                var html = html + '<a onclick="getID(\''+row.podcast_id+'\')" href="#" class="dropdown-item" data-toggle="modal" data-target="#modalRecom"><i class="zmdi zmdi-calendar zmdi-hc-fw" ></i>Recommendation</a>'
                            }
                            if (row.visible=="N") {
                                var html = html + '<a onclick="activeConfirm(\''+base_url+'podcast/podcast_v1/activated/'+row.podcast_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Activate Podcast</a>'
                            } else {
                                var html = html + '<a onclick="inactiveConfirm(\''+base_url+'podcast/podcast_v1/inactivated/'+row.podcast_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate Podcast</a>'
                            }
                        var html = html+'<a href="'+base_url+'podcast/podcast_v1/detail/'+row.podcast_id+'" class="dropdown-item"><i class="zmdi zmdi-search-in-page zmdi-hc-fw"></i>Detail</a><a href="'+base_url+'podcast/podcast_v1/getedit_podcast/'+row.podcast_id+'" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a></div></div>'
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
                { "orderable": false, "targets": 3 },
                { "orderable": false, "targets": 4 }
            ],
            'serverMethod': 'post',
            'ajax': {
              'url':'<?=base_url()?>podcast/podcast_v1/inactive_podcast'
            },
            'columns': [
                { data: 'podcast_id' },
                { "render": function ( data, type, row ) {
                        var imgLink = row.podcast_image
                        var html = '<img id="myImg" src="' + imgLink + '" alt="" width="80" height="80">'
                        return html;
                    }
                },
                { data: 'podcast_name' },
                { data: 'categories' },
                { "render": function ( data, type, row ) {
                        var base_url ='<?php echo base_url()?>'
                        var html  = '<div class="dropdown"><button class="btn btn-light dropdown-toggle" data-toggle="dropdown">ACTION</button><div class="dropdown-menu dropdown-menu--icon">'
                            if (row.visible=="N") {
                                var html = html + '<a onclick="activeConfirm(\''+base_url+'podcast/podcast_v1/activated/'+row.podcast_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Activate Podcast</a>'
                            } else {
                                var html = html + '<a onclick="inactiveConfirm(\''+base_url+'podcast/podcast_v1/inactivated/'+row.podcast_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Deactivate Podcast</a>'
                            }
                        var html = html+'<a href="'+base_url+'podcast/podcast_v1/detail/'+row.podcast_id+'" class="dropdown-item"><i class="zmdi zmdi-search-in-page zmdi-hc-fw"></i>Detail</a><a href="'+base_url+'podcast/podcast_v1/getedit_podcast/'+row.podcast_id+'" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a></div></div>'
                        return html
                    }
                },
            ]
        });
    });
    
    function getID(podcast_id){
        console.log('podcast_id ', podcast_id);
        $('#podcast_id').val(podcast_id);
        $("#datetimepickerstart").flatpickr().clear()
        $("#datetimepickerstart").prop('readonly', false)
        $("#datetimepickerend").flatpickr().clear()
        $("#datetimepickerend").prop('readonly', false)
    }

    function getIDS(podcast_id, start_periode, end_periode){
        console.log('podcast_id ', podcast_id);
        console.log('start_periode ', start_periode);
        console.log('end_periode ', end_periode);
        $('#podcast_id').val(podcast_id);
        $('[name="datetimepickerstart"]').val(start_periode).trigger('change');
        $('[name="datetimepickerend"]').val(end_periode).trigger('change');
    }

    $( function() {
        $("#datetimepickerstart").flatpickr({
            enableTime: true,
            time_24hr: true,
            enableSeconds: true,
            minuteIncrement: 1,
            dateFormat: "Y-m-d",
        })
        $("#datetimepickerstart").prop('readonly', false)
    });

    $( function() {
        $("#datetimepickerend").flatpickr({
            enableTime: true,
            time_24hr: true,
            enableSeconds: true,
            minuteIncrement: 1,
            dateFormat: "Y-m-d",
        })
        $("#datetimepickerend").prop('readonly', false)
    });
</script>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>