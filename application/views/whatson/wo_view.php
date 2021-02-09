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
					<a href="<?php echo site_url('whatson/add_new');?>"><i class="btn btn-light">Add</i></a>
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
								<th>What's On ID</th>
								<th>What's On Title</th>
								<th>What's On Description</th>
								<!-- <th>What's On Image</th> -->
								<!-- <th>What's On Video</th> -->
								<th>Channel What's On</th>
								<th>Thumbnail What's On</th>
								<th>What's On Purpose</th>
								<th>What's On Banner</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 0;
							foreach ($whatson->result() as $row):
      					// echo base_url($row->whatson_image);
								$no++;
							?>
							<tr>
								<td><?php echo $no;?></td>
								<td><?php echo $row->whatson_id;?></td>
								<td><?php echo $row->whatson_title;?></td>
								<td><?php echo substr($row->whatson_description, 0, 20)?></td>
								<!-- <td><img src="<?php echo base_url('media/img/'.$row->whatson_image) ?>" width="64" /></td> -->
								<!-- <td><img src="<?php echo $row->whatson_image; ?>" width="64" /></td> -->
								<!-- <td><?php echo $row->whatson_video;?></td> -->
								<td><?php echo $row->channel_whatson_name;?></td>
								<td><?php echo $row->thumbnail_whatson_name;?></td>
								<td><?php echo $row->whatson_purpose == 0 ? "Whatson" : "DensPlay" ?></td>
								<td><?php echo $row->whatson_banner_active == 0 ? "<button type='button' class='btn btn-outline-danger' disabled>Inactive</button>" : "<button type='button' class='btn btn-outline-success' disabled>Active</button>" ?></td>
								<td align="center">
									<div class="dropdown">
										<button class="btn btn-light dropdown-toggle" data-toggle="dropdown">ACTION</button>

										<div class="dropdown-menu dropdown-menu--icon">
											<?php if($row->category_whatson_id ==2){
											?>
												<a onclick="getChannel('<?php echo $row->content_id; ?>')" href="#" class="dropdown-item" data-toggle="modal" data-target="#modalEPG"><i class="zmdi zmdi-calendar zmdi-hc-fw" ></i>EPG</a>
											<?php
												}
											?>
											<?php if($row->whatson_banner_active ==0){
											?>
												<a onclick="activeConfirm('<?php echo site_url('whatson/activated/'.$row->whatson_id);?>')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Actived Banner</a>
											<?php
												}
											?>
											<?php if($row->whatson_banner_active ==1){
											?>
												<a onclick="inactiveConfirm('<?php echo site_url('whatson/inactivated/'.$row->whatson_id);?>')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Inactived Banner</a>
											<?php
												}
											?>
											<a href="<?php echo site_url('wo_content/add_new/'.$row->whatson_id);?>" class="dropdown-item"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Add Content</a>
											<a href="<?php echo site_url('whatson/detail/'.$row->whatson_id);?>" class="dropdown-item"><i class="zmdi zmdi-search-in-page zmdi-hc-fw"></i>Detail</a>
											<a href="<?php echo site_url('whatson/get_edit/'.$row->whatson_id);?>" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a>
											<a onclick="deleteConfirm('<?php echo site_url('whatson/delete/'.$row->whatson_id);?>')" href="#!" class="dropdown-item"><i class="zmdi zmdi-delete zmdi-hc-fw"></i>Delete</a>                 
										</div>
									</div>
								</td>
							</tr>
						<?php endforeach;?>
					</tbody>
				</table>
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
		$('#mytable').DataTable();
	});

	function activeConfirm(url){
		$('#btn-active').attr('href', url);
		$('#activeModal').modal();
	}

	function inactiveConfirm(url){
		$('#btn-inactive').attr('href', url);
		$('#inactiveModal').modal();
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