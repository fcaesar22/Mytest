<div class="content__inner">
<div class="card">
	<div class="card-body">
	<div class="row">
		<div class="col-md-3">
			<a href="<?php echo site_url('category_whatson/cat_wo') ?>"><i class="btn btn-light" class="card-title">Back</i></a>
		</div>
		<div class="col-md-12" align="center">
			<h4 class="card-title">Edit Category What's On</h4>
		</div>
	</div>
	<hr>
	<br>
	<div id="content-wrapper">
		<div class="container-fluid">
			<form action="<?php base_url("category_whatson/cat_wo/edit") ?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $cat_wo->category_whatson_id?>" />
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="name" style="margin-bottom: 22px;">Category What's On Name*</label>
							<input class="form-control <?php echo form_error('category_whatson_name') ? 'is-invalid':'' ?>"
							 type="text" name="category_whatson_name" placeholder="Category What's On Name" value="<?php echo $cat_wo->category_whatson_name ?>" />
							<div class="invalid-feedback">
								<?php echo form_error('category_whatson_name') ?>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="name">Category What's On Description*</label>
							<textarea class="form-control <?php echo form_error('category_whatson_description') ? 'is-invalid':'' ?>"
							 name="category_whatson_description" placeholder="Category What's On description..."><?php echo $cat_wo->category_whatson_description ?></textarea>
							<div class="invalid-feedback">
								<?php echo form_error('category_whatson_description') ?>
							</div>
						</div>
					</div>
					<div class="col-md-12" align="center">
						<input class="btn btn-success" type="submit" name="btn" value="Save" />
					</div>
				</div>
			</form>
		</div>
	</div>
	</div>
</div>
</div>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>