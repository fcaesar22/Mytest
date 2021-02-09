<div class="content__inner">
<div class="card">
    <div class="card-body">
    <div class="row">
    	<div class="col-md-3">
    		<a href="<?php echo site_url('channel_whatson/ch_wo') ?>"><i class="btn btn-light" class="card-title">Back</i></a>
    	</div>
    	<div class="col-md-12" align="center">
    		<h4 class="card-title">Detail Channel What's On</h4><br>
    	</div>
    </div>
    <br>
        <div class="table-responsive">
            <table class="table mb-0" style="width:100%">
            	<tr>
				    <th>Channel What's On Name :</th>
				    <td><?php echo $ch_wo->channel_whatson_name ?></td>
			  	</tr>
			  	<tr>
			    	<th>Channel What's On Description :</th>
			    	<td><?php echo $ch_wo->channel_whatson_description ?></td>
			  	</tr>
                <tr>
                    <th>Channel What's On Image :</th>
                    <td><img src="<?php echo ('http://whatson.dens.tv/media/img/'.$ch_wo->channel_whatson_logo) ?>" width="64" /></td>
                </tr>
			</table>       
        </div>
    </div>
</div>
</div>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>