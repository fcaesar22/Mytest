<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/flatpickr/dist/flatpickr.min.css" />
<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">

<div class="content__inner">
<div class="card">
    <div class="card-body">
    <div class="row">
    	<div class="col-md-3">
    		<a href="<?php echo site_url('whatson/wo_content') ?>"><i class="btn btn-light" class="card-title">Back</i></a>
    	</div>
    	<div class="col-md-12" align="center">
    		<h4 class="card-title">Edit Channel What's On Content</h4>
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
		<form action="<?php echo site_url('whatson/whatson/wo_content/update_product');?>" method="post">
	      	<div class="row">
	      		<div class="col-sm-6">
		      		<div class="form-group">
					    <label>Type</label>
					    <!-- <input type="text" class="form-control" name="type" placeholder="Type" required> -->
					    <select class="form-control js-example-basic-single" name="type" required>
					    	<option value="image">Image</option>
					    	<option value="video">Video</option>
					    </select>
					    <i class="form-group__bar"></i>
					</div>
				</div>
				<div class="col-sm-6">
		      		<div class="form-group">
					    <label>URL Image</label><a class="btn btn-light btn-sm callfunction2" data-toggle="modal" name="channel_whatson_logo" data-target="#modal-content" id='butcontent'>Choose Image</a>
					    <input type="text" class="form-control textImage" name="url" placeholder="URL" required>
					    <i class="form-group__bar"></i>
					</div>
				</div>
				<div class="col-sm-6">
	                <div class="form-group">
	                  <label for="datetimepicker">Created At</label>
	                  <div class='input-group date'>
	                        <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
	                        <input type="text" id="datetimepicker" name="created_at" placeholder="Pick a date & time" class="form-control">
	                        <i class="form-group__bar"></i>
	                  </div>
	                </div>
	            </div>
	            <div class="col-sm-6">
		      		<div class="form-group">
					    <label>Created By</label>
					    <input type="text" class="form-control" name="created_by" placeholder="Created By" required>
					    <i class="form-group__bar"></i>
					</div>
				</div>
				<input type="hidden" name="whatson_content_id" value="<?php echo $whatson_content_id?>" required>
				<div class="col-sm-12" align="center">
					<button class="btn btn-success" type="submit">Update</button>
				</div>
			</div>
		</form>

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
	function getUrlContent(){
		var image = $('#modal-content .image_picker_selector').find('.selected').find('img').attr('src');
		var images = 'http://pic.dens.tv/wp/img/whatson_v2/1280x720/'+image.replace(/.*\//, '');
	  	//$('image-picker').hide();

	  	$('.textImage').val(images);
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
        	var whatson_content_id = $('[name="whatson_content_id"]').val();
        	$.ajax({
        		url : "<?php echo site_url('whatson/wo_content/get_data_edit');?>",
                method : "POST",
                data :{whatson_content_id :whatson_content_id},
                async : true,
                dataType : 'json',
                success : function(data){
                    $.each(data, function(i, item){
                        $('[name="type"]').val(data[i].type).trigger('change');
                        $('[name="url"]').val(data[i].url).trigger('change');
                        $('[name="created_at"]').val(data[i].created_at).trigger('change');
                        $('[name="created_by"]').val(data[i].created_by).trigger('change');
                    });
                }
        	});
        }
    });

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
            url: '<?php echo base_url() ?>whatson/wo_content/get_token',
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
	          url: '<?php echo base_url() ?>whatson/wo_content/compare_image',
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

    $('.js-example-basic-single').select2();
	</script>

</div>
</div>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>