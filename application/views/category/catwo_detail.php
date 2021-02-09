<div class="content__inner">
<div class="card">
    <div class="card-body">
    <div class="row">
    	<div class="col-md-3">
    		<a href="<?php echo site_url('category_whatson/cat_wo') ?>"><i class="btn btn-light" class="card-title">Back</i></a>
    	</div>
    	<div class="col-md-12" align="center">
    		<h4 class="card-title">Detail Category What's On</h4><br>
    	</div>
    </div>
    <br>
        <div class="table-responsive">
            <table class="table mb-0" style="width:100%">
            	<tr>
				    <th>Category What's On Name :</th>
				    <td><?php echo $cat_wo->category_whatson_name ?></td>
			  	</tr>
			  	<tr>
			    	<th>Category What's On Description :</th>
			    	<td><?php echo substr($cat_wo->category_whatson_description, 0, 120) ?></td>
			  	</tr>
			</table>       
        </div>
    </div>
</div>
</div>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>