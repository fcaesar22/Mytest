<div class="content__inner">
<div class="card">
    <div class="card-body">
    <div class="row">
    	<div class="col-md-3">
    		<a href="<?php echo site_url('whatson/wo_content') ?>"><i class="btn btn-light" class="card-title">Back</i></a>
    	</div>
    	<div class="col-md-12" align="center">
    		<h4 class="card-title">Detail What's On Content</h4><br>
    	</div>
    </div>
    <br>
        <div class="table-responsive">
            <table class="table mb-0" style="width:100%">
            	<tr>
				    <th>Whatson ID :</th>
				    <td><?php echo $whatson_content->whatson_id ?></td>
			  	</tr>
			  	<tr>
			    	<th>What's On Title :</th>
			    	<td><?php echo $whatson_content->whatson_title ?></td>
			  	</tr>
                <tr>
                    <th>What's On Type :</th>
                    <td><?php echo $whatson_content->type ?></td>
                </tr>
                <tr>
                    <th>What's On Content Image :</th>
                    <td><img src="<?php echo (''.$whatson_content->url) ?>" width="64" /></td>
                </tr>
                <tr>
                    <th>Created At :</th>
                    <td><?php echo $whatson_content->created_at ?></td>
                </tr>
                <tr>
                    <th>Created By :</th>
                    <td><?php echo $whatson_content->created_by ?></td>
                </tr>
			</table>       
        </div>
    </div>
</div>
</div>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>