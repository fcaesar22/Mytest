<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/flatpickr/dist/flatpickr.min.css" />
<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">

<div class="content__inner">
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-3">
				<a href="<?php echo site_url('whatson/whatson') ?>"><i class="btn btn-light" class="card-title">Back</i></a>
			</div>
			<div class="col-md-12" align="center">
				<h4 class="card-title">Edit What's On</h4>
			</div>
		</div>
		<hr>
		<br>
		<style>
			select {display: block !important;}
			select.image-picker {margin-bottom: 20px;}
			.image_picker_image {width: 200px;height: 130px;}
			#select option {color: black;}
			#whatson_purpose option {color: black;}
			#whatson_type option {color: black;}
		</style>
		<div id="content-wrapper">
			<div class="container-fluid">
				<form action="<?php echo site_url('whatson/whatson/update_product');?>" method="post">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>What's On Title</label>
								<input type="text" class="form-control" name="whatson_title" placeholder="What's On Title" required>
								<i class="form-group__bar"></i>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>What's On Image</label>
								<a class="btn btn-light btn-sm callfunction" data-toggle="modal" name="whatson_image" data-target="#modal-image" id='butimage'>Choose Image</a>
								<input type="text" class="form-control textImage" id= 'whimage' name="whatson_image" placeholder="what's on image" required>
								<i class="form-group__bar"></i>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>What's On Video</label>
								<input type="text" class="form-control" name="whatson_video" placeholder="what's on video">
								<i class="form-group__bar"></i>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Content ID</label>
								<input type="text" class="form-control" name="content_id" placeholder="Content ID" required>
								<i class="form-group__bar"></i>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Category What's On</label>
								<select id="select" class="form-control js-example-basic-single" name="category" required>
									<?php foreach($category as $row):?>
										<option value="<?php echo $row->category_whatson_id;?>"><?php echo $row->category_whatson_name;?></option>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Sub Category What's On Name</label>
								<select id="select" class="form-control js-example-basic-single" name="subcategory" id="subcategory" required>
									<?php foreach($subcategory as $row):?>
										<option value="<?php echo $row->sub_category_whatson_id;?>"><?php echo $row->sub_category_whatson_name;?></option>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Channel What's On Name</label>
								<select id="select" class="form-control js-example-basic-single" name="channelwo" id="channelwo" required>
									<?php foreach($channelwo as $row):?>
										<option value="<?php echo $row->channel_whatson_id;?>"><?php echo $row->channel_whatson_name;?></option>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Thumbnail What's On Name</label>
								<select id="select" class="form-control js-example-basic-single" name="thumbnailname" id="thumbnailname" required>
									<?php foreach($thumbnailname as $row):?>
										<option value="<?php echo $row->thumbnail_whatson_id;?>"><?php echo $row->thumbnail_whatson_name;?></option>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Content URL</label>
								<input type="text" class="form-control" name="content_url" placeholder="Content URL" required>
								<i class="form-group__bar"></i>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Content URL Image</label><a class="btn btn-light btn-sm callfunction2" data-toggle="modal" name="content_url_image" data-target="#modal-content" id='butcontent'>Choose Image</a>
								<input type="text" class="form-control textContent" id= 'whcontent' name="content_url_image" placeholder="what's on image" required>
								<i class="form-group__bar"></i>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="datetimepicker">What's On Schedule Time</label>
								<div class='input-group date'>
									<span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
									<input type="text" id="datetimepicker" name="whatson_schedule_time" placeholder="Pick a date & time" class="form-control">
									<i class="form-group__bar"></i>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>What's On Purpose</label>
								<select class="form-control js-example-basic-single" name="whatson_purpose" id="whatson_purpose" required>
									<option value="0">What's On</option>
									<option value="1">DensPlay</option>
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>What's On Type</label>
								<select class="form-control js-example-basic-single" name="whatson_type" id="whatson_type" required>
									<option value="1">Text</option>
									<option value="2">Image</option>
									<option value="3">Video</option>
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Link Go To URL</label>
								<input type="text" class="form-control" name="link_url" placeholder="Link Go To URL">
								<i class="form-group__bar"></i>
							</div>
						</div>
						<input type="hidden" name="whatson_id" value="<?php echo $whatson_id?>" required>
						<div class="col-sm-12" align="center">
							<button class="btn btn-success" type="submit">Update</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>

<div class="modal fade" id="modal-image" tabindex="-1" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title pull-left">Select an image</h5>
			</div>
			<div class="modal-body">
				<div id="changing-contentimage">
					<select class='image-picker show-html'>
						<?php
						if($gallery!=null){
							for ($i=0; $i < count($gallery) ; $i++) { 
								$counter = $i+1;
								echo "<option data-img-src='".$gallery[$i]."' data-img-alt='Image ".$counter."' value='".$gallery[$i]."'> Image ".$counter."</option>";
							}
						}

						?>
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<button id="uploadimage" type="button" class="btn btn-link">Upload Image</button>
				<button type="button" class="btn btn-link" onclick="getUrlImage()">Save</button>
				<button id="backimage" type="button" class="btn btn-link callfunction">Images</button>
				<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-content" tabindex="-1" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title pull-left">Select an image</h5>
			</div>
			<div class="modal-body">
				<div id="changing-content2">
					<select class='image-picker show-html'>
						<?php
						if($gallery!=null){
							for ($i=0; $i < count($gallery) ; $i++) { 
								$counter = $i+1;
								echo "<option data-img-src='".$gallery[$i]."' data-img-alt='Image ".$counter."' value='".$gallery[$i]."'> Image ".$counter."</option>";
							}
						}

						?>
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<button id="uploadcontent" type="button" class="btn btn-link">Upload Image</button>
				<button type="button" class="btn" onclick="getUrlContent()">Save</button>
				<button id="backcontent" type="button" class="btn btn-link callfunction2">Images</button>
				<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script src="<?=base_url()?>assets/image-picker/image-picker.js"></script>
<script src="<?=base_url()?>assets/vendors/bower_components/flatpickr/dist/flatpickr.min.js"></script>
<script src="<?=base_url()?>assets/vendors/bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">
$('.js-example-basic-single').select2();

function getUrlImage(){
	var image = $('#modal-image .image_picker_selector').find('.selected').find('img').attr('src');
	$('.textImage').val(image);
	$('#modal-image').modal('hide');
}

function getUrlContent(){
	var image = $('#modal-content .image_picker_selector').find('.selected').find('img').attr('src');
	$('.textContent').val(image);
	$('#modal-content').modal('hide');
}

$(document).ready(function() {
	get_data_edit();

	$( function() {
		$("#datetimepicker").flatpickr({
			enableTime: true,
			time_24hr: true,
			enableSeconds: true,
			minuteIncrement: 1,
			dateFormat: "Y-m-d H:i:S",
		});
	});

	//load data for edit
	function get_data_edit(){
		var whatson_id = $('[name="whatson_id"]').val();
		$.ajax({
			url : "<?php echo site_url('whatson/whatson/get_data_edit');?>",
			method : "POST",
			data :{whatson_id :whatson_id},
			async : true,
			dataType : 'json',
			success : function(data){
				$.each(data, function(i, item){
					$('[name="whatson_title"]').val(data[i].whatson_title);
					$('[name="whatson_image"]').val(data[i].whatson_image);
					$('[name="whatson_video"]').val(data[i].whatson_video);
					$('[name="category"]').val(data[i].category_whatson_id).trigger('change');
					$('[name="subcategory"]').val(data[i].sub_category_whatson_id).trigger('change');
					$('[name="channelwo"]').val(data[i].channel_whatson_id).trigger('change');
					$('[name="thumbnailname"]').val(data[i].thumbnail_whatson_id).trigger('change');
					$('[name="content_id"]').val(data[i].content_id).trigger('change');
					$('[name="content_url"]').val(data[i].content_url).trigger('change');
					$('[name="content_url_image"]').val(data[i].content_url_image).trigger('change');
					$('[name="whatson_schedule_time"]').val(data[i].whatson_schedule_time).trigger('change');
					$('[name="whatson_purpose"]').val(data[i].whatson_purpose).trigger('change');
					$('[name="whatson_type"]').val(data[i].whatson_type).trigger('change');
					$('[name="link_url"]').val(data[i].link_url).trigger('change');
				});
			}
		});
	}
});

$(document).ready(function () {
	var default_content = $("#changing-contentimage").html();
	console.log(default_content);
	$("select").imagepicker();
	// Change div content
	$('#uploadimage').click(function () {
		$('#changing-contentimage')
		.html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token=<?php print_r($token);?>&thumb=30&CH=whatson_v2&type=image" width="100%" height="400px" frameborder="0"></iframe>');
	});


	$('#uploadimage').click(function () {
		$.ajax({
			url: '<?php echo base_url() ?>whatson/whatson/get_token',
			success: function(data){
				console.log('http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=30&CH=whatson_v2&type=image');
				$('#changing-contentimage')
				.html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=30&CH=whatson_v2&type=image" width="100%" height="400px" frameborder="0"></iframe>');
			}
		});
	});

	//#backimage
	$('.callfunction').click(function () {
		console.log(default_content);
		$.ajax({
			type: "GET",
			url: '<?php echo base_url() ?>whatson/whatson/compare_image',
			success: function(data){
				var _gallery = "<select class='image-picker show-html'>";
				data = JSON.parse(data);
				console.log(data);
				if(data!=null){
					for (var i = 0; i < data.length; i++) {
						var _counter = parseInt(i+1);
						_gallery = _gallery + "<option data-img-src='"+data[i]+"' data-img-alt='Image "+_counter+"' value='"+data[i]+"'> Image "+_counter+"</option>";
					}
				}
				_gallery = _gallery+"</select>";
				console.log(_gallery);
				$('#changing-contentimage').html(_gallery);
				$("select").imagepicker();
			}
		});
	});
});

$(document).ready(function () {
	var default_content = $("#changing-content2").html();
	$("select").imagepicker();
	// Change div content
	$('#uploadcontent').click(function () {
		$('#changing-content2')
		.html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token=<?php print_r($token);?>&thumb=30&CH=whatson_v2&type=image" width="100%" height="400px" frameborder="0"></iframe>');
	});


	$('#uploadcontent').click(function () {
		$.ajax({
			url: '<?php echo base_url() ?>whatson/whatson/get_token',
			success: function(data){
				console.log('http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=30&CH=whatson_v2&type=image');
				$('#changing-content2')
				.html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=30&CH=whatson_v2&type=image" width="100%" height="400px" frameborder="0"></iframe>');
			}
		});
	});

	//#backcontent
	$('.callfunction2').click(function () {
		console.log(default_content);
		$.ajax({
			type: "GET",
			url: '<?php echo base_url() ?>whatson/whatson/compare_image',
			success: function(data){
				var _gallery = "<select class='image-picker show-html'>";
				data = JSON.parse(data);
				console.log(data);
				if(data!=null){
					for (var i = 0; i < data.length; i++) {
						var _counter = parseInt(i+1);
						_gallery = _gallery + "<option data-img-src='"+data[i]+"' data-img-alt='Image "+_counter+"' value='"+data[i]+"'> Image "+_counter+"</option>";
					}
				}

				_gallery = _gallery+"</select>";
				console.log(_gallery);
				$('#changing-content2').html(_gallery);
				$("select").imagepicker();
			}
		});
	});
});
</script>

<footer class="footer hidden-xs-down">
	<p>© Super Admin Responsive. All rights reserved.</p>
</footer>