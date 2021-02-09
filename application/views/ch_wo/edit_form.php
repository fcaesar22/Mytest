<div class="content__inner">
<div class="card">
	<div class="card-body">
	<div class="row">
		<div class="col-md-3">
			<a href="<?php echo site_url('channel_whatson/ch_wo') ?>"><i class="btn btn-light" class="card-title">Back</i></a>
		</div>
		<div class="col-md-12" align="center">
			<h4 class="card-title">Edit Channel What's On</h4>
		</div>
	</div>
	<hr>
	<br>

	<style>
        select {display: block !important;}
        select.image-picker {margin-bottom: 20px;}
    	.image_picker_image {width: 200px;height: 130px;}
    </style>

	<div id="content-wrapper">
		<div class="container-fluid">
			<form action="<?php base_url("channel_whatson/ch_wo/edit") ?>" method="post" enctype="multipart/form-data" >
			<input type="hidden" name="id" value="<?php echo $ch_wo->channel_whatson_id?>" />
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="name" style="margin-bottom: 22px;">Channel What's On Name*</label>
							<input class="form-control <?php echo form_error('channel_whatson_name') ? 'is-invalid':'' ?>"
							 type="text" name="channel_whatson_name" placeholder="Channel What's On Name" value="<?php echo $ch_wo->channel_whatson_name ?>" />
							<div class="invalid-feedback">
								<?php echo form_error('channel_whatson_name') ?>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="name">Channel What's On Description*</label>
							<textarea class="form-control <?php echo form_error('channel_whatson_description') ? 'is-invalid':'' ?>"
							 name="channel_whatson_description" placeholder="Channel What's On description..."><?php echo $ch_wo->channel_whatson_description ?></textarea>
							<div class="invalid-feedback">
								<?php echo form_error('channel_whatson_description') ?>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="name" >Channel What's On Logo*</label><a class="btn btn-light btn-sm callfunction2" data-toggle="modal" name="channel_whatson_logo" data-target="#modal-content" id='butcontent'>Choose Image</a>
							<input class="form-control textImage <?php echo form_error('channel_whatson_logo') ? 'is-invalid':'' ?>" type="text" name="channel_whatson_logo" placeholder="Channel What's On Logo" value="<?php echo $ch_wo->channel_whatson_logo ?>" />
							<div class="invalid-feedback">
								<?php echo form_error('channel_whatson_logo') ?>
							</div>
						</div>
					</div>
					<div class="col-md-12" align="center">
						<input type="hidden" name="channel_whatson_id" value="<?php echo $ch_wo->channel_whatson_id?>" required>
						<input class="btn btn-success" type="submit" name="btn" value="Save" />
					</div>
				</div>
			</form>
		</div>
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
				<div id="changing-content">
					<select class='image-picker show-html'>
			          <?php
			            if($gallery!=null){
				            for ($i=0; $i < count($gallery2) ; $i++) { 
				              $counter = $i+1;
				               echo "<option data-img-src='".$gallery2[$i]."' data-img-alt='Image ".$counter."' value='".$gallery2[$i]."'> Image ".$counter."</option>";
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


<!-- <script src="<?=base_url()?>assets/jquery/jquery.js"></script> -->
<script src="<?=base_url()?>assets/image-picker/image-picker.js"></script>

<script type="text/javascript">
function getUrlContent(){
	var image = $('#modal-content .image_picker_selector').find('.selected').find('img').attr('src');
  	//$('image-picker').hide();

  	$('.textImage').val(image);
  	$('#modal-content').modal('hide');

}

	$(document).ready(function () {
		var default_content = $("#changing-content").html();
		$("select").imagepicker();

		// Change div content
		$('#uploadcontent').click(function () {
	      $('#changing-content')
	      .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token=<?php print_r($token);?>&thumb=50&CH=whatson_v2&type=image" width="100%" height="400px" frameborder="0"></iframe>');
	    });


	        $('#uploadcontent').click(function () {
        $.ajax({
            url: '<?php echo base_url() ?>channel_whatson/ch_wo/get_token',
            success: function(data){
            console.log('http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=50&CH=whatson_v2&type=image');
            $('#changing-content')
            .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=50&CH=whatson_v2&type=image" width="100%" height="400px" frameborder="0"></iframe>');
            }
        });
      });

		$('#back').click(function () {
			$('#changing-content')
			.html(default_content);
		});

		$('.callfunction2').click(function () {
	        console.log(default_content);
	        $.ajax({
	          type: "GET",
	          url: '<?php echo base_url() ?>channel_whatson/ch_wo/compare_image/',
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
	                $('#changing-content').html(_gallery);
	                $("select").imagepicker();
	          }
	        });
	        // $('#changing-content').html(default_content);
	        // $("select").imagepicker();
	    });

	});


</script>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>