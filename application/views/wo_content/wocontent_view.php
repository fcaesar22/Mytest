<div class="content__inner">
<header class="content__title">
    <h1>What's On Content</h1>
    <?php echo $this->session->flashdata('msg');?>
</header>
<div class="card">
	<div class="card-body">
	<div class="row">
<!-- 		<div class="col-md-3">
			<a href="<?php echo site_url('whatson/wo_content/add_new');?>"><i class="btn btn-light">Add</i></a>
		</div> -->
		<div class="col-md-12" align="center">
			<h4 class="card-title">What's On Content</h4><hr>
		</div>
	</div>	
	    <div class="table-responsive">
	    	<div style="overflow-x:auto;">
		    <table id="mytable" class="table table-striped table-bordered" cellspacing="0" width="100%">
	      		<thead>
	      			<tr>
	      				<th>No</th>
	      				<th>What's On ID</th>
	      				<th>What's On Title</th>
	      				<th>Type</th>
	      				<!-- <th>URL</th> -->
	      				<th>Created at</th>
	      				<!-- <th>Created by</th> -->
	      				<th>Action</th>
	      			</tr>
	      		</thead>
	      		<tbody>
      			<?php
      				$no = 0;
      				foreach ($whatson_content->result() as $row):
      					$no++;
      			?>
	      			<tr>
	      				<td><?php echo $no;?></td>
	      				<td><?php echo $row->whatson_id;?></td>
	      				<td><?php echo $row->whatson_title;?></td>
	      				<td><?php echo $row->type;?></td>
	      				<!-- <td><?php echo $row->type=='image'? "<img src='".$row->url."' width='45px'>":$row->type?></td> -->
	      				<td><?php echo $row->created_at;?></td>
	      				<!-- <td><?php echo $row->created_by;?></td> -->	      				
	      				<td align="center">
	      					<div class="dropdown">
	                        <button class="btn btn-light dropdown-toggle" data-toggle="dropdown">ACTION</button>
	                        <div class="dropdown-menu dropdown-menu--icon">
	                            <a href="<?php echo site_url('whatson/wo_content/detail/'.$row->whatson_content_id) ?>" class="dropdown-item"><i class="zmdi zmdi-search-in-page zmdi-hc-fw"></i> Detail</a>
	                            <a href="<?php echo site_url('whatson/wo_content/get_edit/'.$row->whatson_content_id);?>" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a>
		      					<!-- <a onclick="deleteConfirm('<?php echo site_url('whatson/wo_content/delete/'.$row->whatson_content_id);?>')" href="#!" class="dropdown-item"><i class="zmdi zmdi-delete zmdi-hc-fw"></i>Delete</a> -->                 
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

<!-- Logout Delete Confirmation-->
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

<script type="text/javascript" src="<?php echo base_url().'assets/js/datatables.js'?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#mytable').DataTable();
	});

    // function deleteConfirm(url){
	   //  $('#btn-delete').attr('href', url);
	   //  $('#deleteModal').modal();
    // }
</script>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>