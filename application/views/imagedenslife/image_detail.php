<div class="content__inner">
<div class="card">
    <div class="card-body">
    <div class="row">
    	<div class="col-md-3">
    		<a href="<?php echo site_url('imagedenslife') ?>"><i class="btn btn-light" class="card-title">Back</i></a>
    	</div>
    	<div class="col-md-12" align="center">
    		<h4 class="card-title">Detail Image</h4><br>
    	</div>
    </div>
    <br>
        <div class="table-responsive">
            <table class="table mb-0" style="width:100%">
            	<tr>
				    <th>Poster ID :</th>
				    <td><?php echo $tmp_poster->sptr ?></td>
			  	</tr>
			  	<tr>
			    	<th>Article Title :</th>
			    	<td><?php echo $tmp_poster->article_title ?></td>
			  	</tr>
                <tr>
                    <th>Poster Type :</th>
                    <td><?php echo $tmp_poster->poster_type ?></td>
                </tr>
                <tr>
                    <th>Poster URL :</th>
                    <td><img src="<?php echo $tmp_poster->poster_url ?>" width="64" /></td>
                </tr>
                <tr>
                    <th>Poster Visible :</th>
                    <td><?php echo $tmp_poster->poster_visible ?></td>
                </tr>
                <tr>
                    <th>Product ID :</th>
                    <td><?php echo $tmp_poster->product_id ?></td>
                </tr>
			</table>       
        </div>
    </div>
</div>
</div>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>