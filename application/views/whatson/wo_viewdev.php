<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/flatpickr/dist/flatpickr.min.css" />
<link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">
<div class="content__inner">
<style>
    .flatpickr-calendar {
        margin-top: -200px;
    }

</style>
	<header class="content__title">
		<h1>What's On</h1>
		<?php echo $this->session->flashdata('msg');?>
	</header>
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-md-3">
					<a href="<?php echo site_url('whatson/whatson/add_new');?>"><i class="btn btn-light">Add</i></a>
				</div>
				<div class="col-md-12" align="center">
					<h4 class="card-title">What's On</h4><hr>
				</div>
			</div>	
			<div class="table-responsive">
				<div style="overflow-x:auto;">
					<table id="mytable" class="table table-inverse table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>No</th>
								<th>ID</th>
								<th>What's On Title</th>
								<th>What's On Description</th>
								<th>What's On Category</th>
								<th>What's On Image</th>
								<th>What's On Purpose</th>
								<th>What's On Banner</th>
								<th>What's On PIN Banner</th>
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

<!--Active/Inactive banner Confirmation-->
<div class="modal fade" name="activeModal" id="activeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="activeBanner" name="activeBanner" action="#" method="post">
			<div class="modal-header">
				<div class="modal-body" align="center">Are you sure?</div>
				<div class="form-group">
					<input type="hidden" name="id_whon" id="id_whon">
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
				<a id="btn-active" type="button" id="btnSave" onclick="save()" class="btn btn-danger">Yes</a>
			</div>
			</form>
		</div>
	</div>
</div>

<!--Pin banner Confirmation-->
<div class="modal fade" name="pinModal" id="pinModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<form id="activePin" name="activePin" action="#" method="post">
			<div class="modal-header">
				<div class="modal-body" align="center">Are you sure?</div>
				<div class="form-group">
					<input type="hidden" name="id_whonpin" id="id_whonpin">
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
				<a id="btn-activepin" type="button" id="btnPin" onclick="save_pin()" class="btn btn-danger">Yes</a>
			</div>
			</form>
		</div>
	</div>
</div>

<!--Unpin banner Confirmation-->
<div class="modal fade" id="unpinModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-body" align="center">Are you sure?</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
				<a id="btn-unpin" class="btn btn-danger" href="#">Inactive</a>
			</div>
		</div>
	</div>
</div>

<!--Delete Confirmation-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-body" align="center">Are you sure?</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
				<a id="btn-delete" class="btn btn-danger" href="#">Delete</a>
			</div>
		</div>
	</div>
</div>



<div class="modal fade show" id="modalEPG" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title pull-left">EPG</h5>
			</div>
			<div class="modal-body">

				Anda akan diarahkan ke EPG, silahkan memilih tanggal dan waktu
				<form action="" method="post">
				<div class="col-sm-6">
                <div class="form-group">

	                <label for="datetimepicker">EPG Schedule Time</label>
	                <div class='input-group date'>
	                    <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
	                    <input type="text" id="datetimepicker" name="datetimepicker" placeholder="Pick a date & time" class="form-control">
	                    <i class="form-group__bar"></i>
	                </div>
	                <div id="ch_id" style="display: none"><input type="text" name="ch_id" id="channel_id" value=""></div>
                </div>
               
              	</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-link" onclick="toEPG()">Go To EPG</button>
				<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
			</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url().'assets/js/datatables.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/vendors/bower_components/flatpickr/dist/flatpickr.min.js'?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
	   	$('#mytable').DataTable({
	      	'processing': true,
	      	'serverSide': true,
	      	"aLengthMenu": [[10, 25, 50],[ 10, 25, 50]],
	      	"order": [[ 1, 'desc' ]],
	      	'serverMethod': 'post',
	      	'ajax': {
	          'url':'<?php echo base_url('whatson/whatson/dataList') ?>'
	      	},
	      	'columns': [
	         	{
				    "data": "whatson_id",
				    render: function (data, type, row, meta) {
				        return meta.row + meta.settings._iDisplayStart + 1;
				    }
				},
	         	{ data: 'whatson_id' },
	         	{ data: 'whatson_title' },
	         	{ "render": function ( data, type, row ) {
	                    var description = row.whatson_description
	                    var html = '<span>'+description.substr( 0, 50 )+'...</span>'
	                    return html;
	                }
	            },
	         	{ data: 'category_whatson_name' },
	         	{ "render": function ( data, type, row ) {
	                    var imgLink = row.content_url_image
	                    var html = '<img id="myImg" src="' + imgLink + '" alt="" width="128" height="72">'
	                    return html;
	                }
	            },
	            { "render": function ( data, type, row ) {
	                    var html = ""

	                    if(row.whatson_purpose == 0){
	                        html = 'Whatson'
						}else{
	                        html = 'DensPlay'
	                    }

	                    return html;
	                }
	            },
	            { "render": function ( data, type, row ) {
	                    var html = ""

	                    if(row.whatson_banner_active == 1){
	                        html = "<button type='button' class='btn btn-outline-success' disabled>Active</button>"
						}else{
	                        html = "<button type='button' class='btn btn-outline-danger' disabled>Inactive</button>"
	                    }

	                    return html;
	                }
	            },
	            { "render": function ( data, type, row ) {
	                    var html = ""

	                    if(row.is_pinned == 'Y'){
	                        html = "<button type='button' class='btn btn-outline-success' disabled>Ready</button>"
						}else{
	                        html = "<button type='button' class='btn btn-outline-danger' disabled>Not Ready</button>"
	                    }

	                    return html;
	                }
	            },
	            { "render": function ( data, type, row ) {
	                    var base_url ='<?php echo base_url()?>'
	                    var html  = '<div class="dropdown"><button class="btn btn-light dropdown-toggle" data-toggle="dropdown">ACTION</button><div class="dropdown-menu dropdown-menu--icon">'
		                    if (row.category_whatson_id==2) {
		                    	var html = html + '<a onclick="getChannel(\''+row.content_id+'\')" href="#" class="dropdown-item" data-toggle="modal" data-target="#modalEPG"><i class="zmdi zmdi-calendar zmdi-hc-fw" ></i>EPG</a>'
		                    }
		                    if (row.whatson_banner_active==0) {
		                    	var html = html + '<a onclick="activeConfirm(\''+row.whatson_id+'\')" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Actived Banner</a>'
		                    }
		                    if (row.whatson_banner_active==1) {
		                    	var html = html + '<a onclick="inactiveConfirm(\''+row.whatson_id+'\')" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Inactived Banner</a>'
		                    }
		                    if (row.is_pinned=='N') {
		                    	var html = html + '<a onclick="pinBanner(\''+row.whatson_id+'\')" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Pin Banner</a>'
		                    }
		                    if (row.is_pinned=='Y') {
		                    	var html = html + '<a onclick="unpinBanner(\''+row.whatson_id+'\')" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Unpin Banner</a>'
		                    }
	                    var html = html+'<a href="'+base_url+'whatson/wo_content/add_new/'+row.whatson_id+'" class="dropdown-item"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Add Content</a><a href="'+base_url+'whatson/whatson/detail/'+row.whatson_id+'" class="dropdown-item"><i class="zmdi zmdi-search-in-page zmdi-hc-fw"></i>Detail</a><a href="'+base_url+'whatson/whatson/get_edit/'+row.whatson_id+'" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a><a onclick="deleteConfirm(\''+base_url+'whatson/whatson/delete/'+row.whatson_id+'\')" href="#!" class="dropdown-item"><i class="zmdi zmdi-delete zmdi-hc-fw"></i>Delete</a></div></div>'
	                    return html
	                }
	            },
	      	]
	   	});
	});
	
	var save_method;
	function activeConfirm(id_whon){
		save_method = 'active_banner';
		$('#activeModal').modal();
		$('#id_whon').val(id_whon);
	}

	function inactiveConfirm(id_whon){
		save_method = 'inactive_banner';
		$('#activeModal').modal();
		$('#id_whon').val(id_whon);
	}

	function save(){
		$('#btnSave').text('saving...'); //change button text
    	$('#btnSave').attr('disabled',true); //set button disable 
		var table = $('#mytable').DataTable();
	    var url;
	    if(save_method == 'active_banner') {
        	url = "<?php echo site_url('whatson/whatson/activated/')?>";
	    }
	    if(save_method == 'inactive_banner') {
        	url = "<?php echo site_url('whatson/whatson/inactivated/')?>";
	    }
	    // ajax adding data to database
	    $.ajax({
	        url : url,
	        type: "POST",
	        data: $('#activeBanner').serialize(),
	        dataType: "JSON",
	        success: function(data)
	        {

	            if(data.status) //if success close modal and reload ajax table
	            {
	                $('#activeModal').modal('hide');
	                table.ajax.reload(null, false);
	            }
	            else
	            {
	                for (var i = 0; i < data.inputerror.length; i++) 
	                {
	                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
	                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
	                }
	            }
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            alert('Error adding / update data');
	            $('#btnSave').text('save'); //change button text
	            $('#btnSave').attr('disabled',false); //set button enable 

	        }
	    });
	}

	var save_methodpin;
	function pinBanner(id_whonpin){
		save_methodpin = 'active_pin';
		$('#pinModal').modal();
		$('#id_whonpin').val(id_whonpin);
	}

	function unpinBanner(id_whonpin){
		save_methodpin = 'inactive_pin';
		$('#pinModal').modal();
		$('#id_whonpin').val(id_whonpin);
	}

	function save_pin(){
		$('#btnSave').text('saving...'); //change button text
    	$('#btnSave').attr('disabled',true); //set button disable 
		var table = $('#mytable').DataTable();
	    var url;
	    if(save_methodpin == 'active_pin') {
        	url = "<?php echo site_url('whatson/whatson/pinbanner/')?>";
	    }
	    if(save_methodpin == 'inactive_pin') {
        	url = "<?php echo site_url('whatson/whatson/unpinbanner/')?>";
	    }
	    // ajax adding data to database
	    $.ajax({
	        url : url,
	        type: "POST",
	        data: $('#activePin').serialize(),
	        dataType: "JSON",
	        success: function(data)
	        {

	            if(data.status) //if success close modal and reload ajax table
	            {
	                $('#pinModal').modal('hide');
	                table.ajax.reload(null, false);
	            }
	            else
	            {
	                for (var i = 0; i < data.inputerror.length; i++) 
	                {
	                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
	                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
	                }
	            }
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            alert('Tidak berhasil pin whatson. Jumlah pin sudah maksimal, silahkan unpin salah satu whatson!');
	            $('#btnSave').text('save'); //change button text
	            $('#btnSave').attr('disabled',false); //set button enable 

	        }
	    });
	}

	function deleteConfirm(url){
		$('#btn-delete').attr('href', url);
		$('#deleteModal').modal();
	}

	$( function() {
    $("#datetimepicker").flatpickr({
	    enableTime: true,
	    time_24hr: true,
	    enableSeconds: true,
	    minuteIncrement: 1,
	    dateFormat: "Y-m-d",
	    });
	});

	function toEPG(){
		var data = $('form').serializeArray();
		var url = "http://epg.dens.tv/schedule/admin/manual.php";
		if(data!=null){
			url = url+"?id="+data[1].value+"&dt="+data[0].value;
		}
		window.open(url, "_blank");
		$('#modalEPG').modal('hide');
		console.log(url);
	}

	function getChannel(ch_id){
		console.log('channelid ', ch_id);
		document.getElementById("channel_id").value = ch_id;
	}
</script>

<footer class="footer hidden-xs-down">
	<p>© Super Admin Responsive. All rights reserved.</p>
</footer>